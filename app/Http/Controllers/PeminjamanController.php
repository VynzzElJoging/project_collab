<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Book;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PeminjamanController extends Controller
{
    private const MAKSIMAL_BUKU = 3;
    private const LAMA_PEMINJAMAN = 7;
    private const DENDA_PER_BUKU_PER_HARI = 2000;

    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $peminjamans = Peminjaman::with([
            'anggota',
            'details.book',
        ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('anggota', function ($query) use ($search) {
                        $query->where('nama', 'ILIKE', "%{$search}%");
                    })
                        ->orWhereHas('details.book', function ($query) use ($search) {
                            $query->where('judul', 'ILIKE', "%{$search}%");
                        });
                });
            })
            ->latest('tanggal_pinjam')
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.data.peminjaman',
            compact('peminjamans', 'search')
        );
    }

    public function create()
    {
        $anggotas = Anggota::orderBy('nama')->get();

        $books = Book::query()
            ->where('stok', '>', 0)
            ->orderBy('judul')
            ->get();

        return view(
            'admin.data.peminjaman-create',
            compact('anggotas', 'books')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => [
                'required',
                'exists:anggotas,id',
            ],

            'books' => [
                'required',
                'array',
                'min:1',
                'max:' . self::MAKSIMAL_BUKU,
            ],

            'books.*' => [
                'required',
                'integer',
                'distinct',
                'exists:books,id',
            ],
        ], [
            'books.max' =>
            'Maksimal ' . self::MAKSIMAL_BUKU . ' buku dalam satu transaksi.',

            'books.min' =>
            'Minimal satu buku harus dipilih.',

            'books.*.distinct' =>
            'Buku yang sama tidak boleh dipilih lebih dari satu kali.',
        ]);

        DB::transaction(function () use ($validated) {

            $books = Book::query()
                ->whereIn('id', $validated['books'])
                ->lockForUpdate()
                ->get();

            if ($books->count() !== count($validated['books'])) {
                throw ValidationException::withMessages([
                    'books' => 'Terdapat buku yang tidak ditemukan.',
                ]);
            }

            foreach ($books as $book) {
                if ($book->stok < 1) {
                    throw ValidationException::withMessages([
                        'books' =>
                        "Stok buku \"{$book->judul}\" sudah habis.",
                    ]);
                }
            }

            $tanggalPinjam = now()->startOfDay();

            $peminjaman = Peminjaman::create([
                'anggota_id' => $validated['anggota_id'],
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_jatuh_tempo' => $tanggalPinjam->copy()
                    ->addDays(self::LAMA_PEMINJAMAN),
                'status' => 'dipinjam',
                'denda' => 0,
            ]);

            foreach ($books as $book) {
                $peminjaman->details()->create([
                    'book_id' => $book->id,
                    'jumlah' => 1,
                ]);

                $book->decrement('stok', 1);
            }
        });

        return redirect()
            ->route('admin.data.peminjaman.index')
            ->with(
                'success',
                'Transaksi peminjaman berhasil dibuat.'
            );
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status === 'dikembalikan') {
            return back()->with(
                'error',
                'Peminjaman ini sudah dikembalikan.'
            );
        }

        DB::transaction(function () use ($peminjaman) {

            $peminjaman->load('details.book');

            $tanggalKembali = now()->startOfDay();

            $terlambat = max(
                0,
                $peminjaman->tanggal_jatuh_tempo
                    ->diffInDays($tanggalKembali, false)
            );

            $jumlahBuku = $peminjaman->details->count();

            $denda = $terlambat
                * $jumlahBuku
                * self::DENDA_PER_BUKU_PER_HARI;

            foreach ($peminjaman->details as $detail) {
                $detail->book->increment('stok', $detail->jumlah);
            }

            $peminjaman->update([
                'tanggal_kembali' => $tanggalKembali,
                'status' => 'dikembalikan',
                'denda' => $denda,
            ]);
        });

        return back()->with(
            'success',
            'Buku berhasil dikembalikan.'
        );
    }
}
