<?php

namespace App\Http\Controllers;

use App\Exports\LaporanPeminjamanExport;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman laporan.
     */
    public function index(Request $request)
    {
        $request->validate([
            'jenis' => 'nullable|in:bulanan,tahunan',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'bulan' => 'nullable|integer|min:1|max:12',
        ]);

        $jenis = $request->input('jenis', 'bulanan');

        $tahun = (int) $request->input(
            'tahun',
            now()->year
        );

        $bulan = (int) $request->input(
            'bulan',
            now()->month
        );

        $laporan = $this->getLaporan(
            $jenis,
            $tahun,
            $bulan
        );

        $statistik = $this->hitungStatistik($laporan);

        return view('admin.data.laporan', compact(
            'laporan',
            'statistik',
            'jenis',
            'tahun',
            'bulan'
        ));
    }


    /**
     * Export laporan ke PDF.
     */
    public function exportPdf(Request $request)
    {
        $request->validate([
            'jenis' => 'nullable|in:bulanan,tahunan',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'bulan' => 'nullable|integer|min:1|max:12',
        ]);

        $jenis = $request->input('jenis', 'bulanan');

        $tahun = (int) $request->input(
            'tahun',
            now()->year
        );

        $bulan = (int) $request->input(
            'bulan',
            now()->month
        );

        $laporan = $this->getLaporan(
            $jenis,
            $tahun,
            $bulan
        );

        $statistik = $this->hitungStatistik($laporan);

        $pdf = Pdf::loadView(
            'admin.data.laporan-pdf',
            compact(
                'laporan',
                'statistik',
                'jenis',
                'tahun',
                'bulan'
            )
        );

        $namaFile = $this->buatNamaFile(
            $jenis,
            $tahun,
            $bulan,
            'pdf'
        );

        return $pdf
            ->setPaper('a4', 'landscape')
            ->download($namaFile);
    }


    /**
     * Export laporan ke Excel.
     */
    public function exportExcel(Request $request)
    {
        $request->validate([
            'jenis' => 'nullable|in:bulanan,tahunan',
            'tahun' => 'nullable|integer|min:2000|max:2100',
            'bulan' => 'nullable|integer|min:1|max:12',
        ]);

        $jenis = $request->input('jenis', 'bulanan');

        $tahun = (int) $request->input(
            'tahun',
            now()->year
        );

        $bulan = (int) $request->input(
            'bulan',
            now()->month
        );

        $laporan = $this->getLaporan(
            $jenis,
            $tahun,
            $bulan
        );

        $statistik = $this->hitungStatistik($laporan);

        $namaFile = $this->buatNamaFile(
            $jenis,
            $tahun,
            $bulan,
            'xlsx'
        );

        return Excel::download(
            new LaporanPeminjamanExport(
                $laporan,
                $statistik,
                $jenis,
                $tahun,
                $bulan
            ),
            $namaFile
        );
    }


    /**
     * Mengambil data laporan berdasarkan periode.
     */
    private function getLaporan(
        string $jenis,
        int $tahun,
        int $bulan
    ) {
        $query = Peminjaman::with([
            'anggota',
            'details.book',
        ]);

        if ($jenis === 'tahunan') {
            $query->whereYear(
                'tanggal_pinjam',
                $tahun
            );
        } else {
            $query
                ->whereYear(
                    'tanggal_pinjam',
                    $tahun
                )
                ->whereMonth(
                    'tanggal_pinjam',
                    $bulan
                );
        }

        return $query
            ->orderBy('tanggal_pinjam')
            ->orderBy('id')
            ->get();
    }


    /**
     * Menghitung statistik laporan.
     */
    private function hitungStatistik($laporan): array
    {
        $totalTransaksi = $laporan->count();

        $totalBuku = $laporan->sum(function ($peminjaman) {
            return $peminjaman->details->sum('jumlah');
        });

        $totalDikembalikan = $laporan
            ->where('status', 'dikembalikan')
            ->count();

        $totalDipinjam = $laporan
            ->where('status', 'dipinjam')
            ->count();

        $totalDenda = $laporan->sum('denda');

        return [
            'total_transaksi' => $totalTransaksi,
            'total_buku' => $totalBuku,
            'total_dikembalikan' => $totalDikembalikan,
            'total_dipinjam' => $totalDipinjam,
            'total_denda' => $totalDenda,
        ];
    }


    /**
     * Membuat nama file export.
     */
    private function buatNamaFile(
        string $jenis,
        int $tahun,
        int $bulan,
        string $extension
    ): string {
        if ($jenis === 'tahunan') {
            return "laporan-peminjaman-{$tahun}.{$extension}";
        }

        return "laporan-peminjaman-{$tahun}-"
            . str_pad($bulan, 2, '0', STR_PAD_LEFT)
            . ".{$extension}";
    }
}
