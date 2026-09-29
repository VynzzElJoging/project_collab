<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // FUNCTION INDEX JANG READ (NAMPILKEUN DATA)
    public function index(Request $request)
    {


        // -> JNG FITUR SORTING ANU BERDASARKAN INPUTAN VIEW
        $urutkeun = $request->input('sort', 'judul_asc');
        $daftarSortingData = [
            'judul_asc',
            'judul_desc',
            'tahun_asc',
            'tahun_desc',
            'stok_asc',
            'stok_desc',
        ];

        if (!in_array($urutkeun, $daftarSortingData, true)) {
            $urutkeun = 'judul_asc';
        }   

        $neanganDataBuku = $request->input('search'); // -> JANG FITUR SEARCH (NGAMBIL DATA INPUTAN SEARCH DI VIEW)
        $filterKategori = $request->input('kategori'); // -> JANG FITUR FILTER KATEGORI BERDASARKAN KATEGORI BUKU
        $tempatNyimpenDataBukus = Book::query()
            ->when($neanganDataBuku, function ($query, $neanganDataBuku) {
                $query
                ->where(function ($query) use ($neanganDataBuku) {
                $query
                ->where('judul', 'ILIKE', "%{$neanganDataBuku}%")
                ->orWhere('penulis', 'ILIKE', "%{$neanganDataBuku}%")
                ->orWhere('penerbit', 'ILIKE', "%{$neanganDataBuku}%");
                });
            })
            ->when($filterKategori, function ($query, $filterKategori) {
                $query->where('kategori', $filterKategori);
            })
            ->when($urutkeun === 'judul_asc', function ($query) {
                $query->orderBy('judul', 'asc');
            })
            ->when($urutkeun === 'judul_desc', function ($query) {
                $query->orderBy('judul', 'desc');
            })
            ->when($urutkeun === 'tahun_asc', function ($query) {
                $query->orderBy('tahun', 'asc');
            })
            ->when($urutkeun === 'tahun_desc', function ($query) {
                $query->orderBy('tahun', 'desc');
            })
            ->when($urutkeun === 'stok_asc', function ($query) {
                $query->orderBy('stok', 'asc');
            })
            ->when($urutkeun === 'stok_desc', function ($query) {
                $query->orderBy('stok', 'desc');
            })
            ->paginate(24)
            ->withQueryString();

        $kategoris = Book::query()
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

            // BARIS IEU JANG NGIRIM DATA KA VIEW BLADE
        return view('admin.data.buku', compact('tempatNyimpenDataBukus', 'neanganDataBuku', 'urutkeun', 'filterKategori', 'kategoris'));
    }

    //FUNCTION CREATE JANG NAMPILKEUN PAGE TAMBAH DATA
    public function create()
    {
        return view('admin.data.buku-create');
    }


    // STORE JANG NYIMPEN DATA ANU DITAMBAHKEUN
    public function store(Request $request)
    {
        $validated =   $request->validate([
            'judul' => 'required|string|max:225',
            'penulis' => 'required|string|max:225',
            'penerbit' => 'required|string|max:225',
            'tahun' => 'required|integer|min:1000|max:' . date('Y'),
            'kategori' => 'required|string|max:225',
            'stok' => 'required|integer|min:0',
            'cover_source' => 'required|in:local,external',

            // IEU JANG COVER ANU ASALNA TINA FILE LOKAL STORAGE SI USER
            'cover_file' => [
                'required_if:cover_source,local',
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,jfif',
                'max:2048',
            ],

            // IEU JANG COVER ANU ASALNA TINA EKSTERNAL (MAKE INTERNET)
            'cover_url' => [
                'required_if:cover_source,external',
                'nullable',
                'url',
                'max:2048',
            ],
        ]);

        // IEU JANG NORMALISASI INPUT -> BISI AYA INPUTAN ANU DI ISI KU USER MENGANDUNG SPASI BERLEBIH KECUALI SPASI ANU AYA DINA TENGAH TENGAH KATA
        $validated['judul'] = trim($validated['judul']);
        $validated['penulis'] = trim($validated['penulis']);
        $validated['penerbit'] = trim($validated['penerbit']);
        $validated['kategori'] = trim($validated['kategori']);

        if ($validated['cover_source'] === 'local') {

            $coverPath = $request->file('cover_file')
                ->store('images/books', 'public');

            $validated['cover'] = $coverPath;
        } else {

            $validated['cover'] = trim($validated['cover_url']);
        }

        unset(
            $validated['cover_source'],
            $validated['cover_file'],
            $validated['cover_url']
        );

        Book::create($validated);

        return redirect()
            ->route('admin.data.buku.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        return view('admin.data.buku-edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun' => 'required|integer|min:1000|max:' . date('Y'),
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
            'cover_source' => 'required|in:local,external',

            'cover_file' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'cover_url' => [
                'required_if:cover_source,external',
                'nullable',
                'url',
                'max:2048',
            ],
        ]);

        $validated['judul'] = trim($validated['judul']);
        $validated['penulis'] = trim($validated['penulis']);
        $validated['penerbit'] = trim($validated['penerbit']);
        $validated['kategori'] = trim($validated['kategori']);

        $coverLama = $book->cover;

        $coverBaru = null;

        if (
            $validated['cover_source'] === 'local'
            && $request->hasFile('cover_file')
        ) {

            $coverBaru = $request->file('cover_file')
                ->store('images/books', 'public');
        } elseif (
            $validated['cover_source'] === 'external'
        ) {

            $coverBaru = trim($validated['cover_url']);
        }

        if ($coverBaru !== null) {

            $validated['cover'] = $coverBaru;
        } else {
            unset($validated['cover']);
        }

        // IEU JANG NGAHAPUS FILE SEMENTARA
        unset(
            $validated['cover_source'],
            $validated['cover_file'],
            $validated['cover_url']
        );

        $book->update($validated);

        if (
            $coverBaru !== null
            && $coverLama
            && !filter_var($coverLama, FILTER_VALIDATE_URL)
        ) {

            if (Storage::disk('public')->exists($coverLama)) {
                Storage::disk('public')->delete($coverLama);
            }
        }

        return redirect()
            ->route('admin.data.buku.index')
            ->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()
            ->route('admin.data.buku.index')
            ->with('success', 'Buku Berhasil Dihapus.');
    }
}
