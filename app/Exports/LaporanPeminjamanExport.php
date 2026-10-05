<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPeminjamanExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize
{
    protected Collection $laporan;

    protected array $statistik;

    protected string $jenis;

    protected int $tahun;

    protected int $bulan;


    public function __construct(
        Collection $laporan,
        array $statistik,
        string $jenis,
        int $tahun,
        int $bulan
    ) {
        $this->laporan = $laporan;
        $this->statistik = $statistik;
        $this->jenis = $jenis;
        $this->tahun = $tahun;
        $this->bulan = $bulan;
    }


    public function collection()
    {
        $rows = collect();

        foreach ($this->laporan as $peminjaman) {

            foreach ($peminjaman->details as $index => $detail) {

                $rows->push([

                    $peminjaman->tanggal_pinjam
                        ? $peminjaman->tanggal_pinjam->format('d-m-Y')
                        : '-',

                    $peminjaman->anggota->nama ?? '-',

                    $detail->book->judul ?? '-',

                    $detail->jumlah,

                    $peminjaman->tanggal_jatuh_tempo
                        ? $peminjaman->tanggal_jatuh_tempo->format('d-m-Y')
                        : '-',

                    $peminjaman->tanggal_kembali
                        ? $peminjaman->tanggal_kembali->format('d-m-Y')
                        : '-',

                    ucfirst($peminjaman->status),

                    $index === 0
                        ? $peminjaman->denda
                        : 0,
                ]);
            }
        }

        return $rows;
    }


    public function headings(): array
    {
        return [
            'Tanggal Pinjam',
            'Anggota',
            'Buku',
            'Jumlah',
            'Jatuh Tempo',
            'Tanggal Kembali',
            'Status',
            'Denda',
        ];
    }
}
