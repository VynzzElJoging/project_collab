<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Laporan Peminjaman</title>

    <style>
        @page {
            margin: 30px 25px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
        }

        .header p {
            margin: 5px 0 0;
            font-size: 11px;
        }

        .summary {
            width: 100%;
            margin-bottom: 20px;
        }

        .summary td {
            width: 20%;
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }

        .summary .label {
            font-size: 9px;
            color: #555;
        }

        .summary .value {
            margin-top: 4px;
            font-size: 13px;
            font-weight: bold;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background: #222;
            color: white;
            padding: 7px 5px;
            border: 1px solid #222;
            text-align: center;
        }

        table.data td {
            padding: 6px 5px;
            border: 1px solid #aaa;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .empty {
            text-align: center;
            padding: 20px;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="header">

        <h1>LAPORAN PEMINJAMAN PERPUSTAKAAN</h1>

        <p>
            @if ($jenis === 'tahunan')
                Periode Tahun {{ $tahun }}
            @else
                Periode
                {{ \Carbon\Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F') }}
                {{ $tahun }}
            @endif
        </p>

    </div>


    <table class="summary">
        <tr>

            <td>
                <div class="label">
                    Total Transaksi
                </div>

                <div class="value">
                    {{ $statistik['total_transaksi'] }}
                </div>
            </td>

            <td>
                <div class="label">
                    Total Buku
                </div>

                <div class="value">
                    {{ $statistik['total_buku'] }}
                </div>
            </td>

            <td>
                <div class="label">
                    Dikembalikan
                </div>

                <div class="value">
                    {{ $statistik['total_dikembalikan'] }}
                </div>
            </td>

            <td>
                <div class="label">
                    Masih Dipinjam
                </div>

                <div class="value">
                    {{ $statistik['total_dipinjam'] }}
                </div>
            </td>

            <td>
                <div class="label">
                    Total Denda
                </div>

                <div class="value">
                    Rp {{ number_format($statistik['total_denda'], 0, ',', '.') }}
                </div>
            </td>

        </tr>
    </table>


    <table class="data">

        <thead>
            <tr>
                <th width="4%">No</th>
                <th>Tanggal Pinjam</th>
                <th>Anggota</th>
                <th>Buku</th>
                <th width="6%">Jumlah</th>
                <th>Jatuh Tempo</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
                <th>Denda</th>
            </tr>
        </thead>

        <tbody>

            @php
                $no = 1;
            @endphp

            @forelse ($laporan as $peminjaman)

                @foreach ($peminjaman->details as $detail)

                    <tr>

                        <td class="text-center">
                            {{ $no++ }}
                        </td>

                        <td class="text-center">
                            {{ $peminjaman->tanggal_pinjam?->format('d-m-Y') ?? '-' }}
                        </td>

                        <td>
                            {{ $peminjaman->anggota->nama ?? '-' }}
                        </td>

                        <td>
                            {{ $detail->book->judul ?? '-' }}
                        </td>

                        <td class="text-center">
                            {{ $detail->jumlah }}
                        </td>

                        <td class="text-center">
                            {{ $peminjaman->tanggal_jatuh_tempo?->format('d-m-Y') ?? '-' }}
                        </td>

                        <td class="text-center">
                            {{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? '-' }}
                        </td>

                        <td class="text-center">
                            {{ ucfirst($peminjaman->status) }}
                        </td>

                        <td class="text-right">
                            @if ($loop->first)
                                Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>

                    </tr>

                @endforeach

            @empty

                <tr>
                    <td colspan="9" class="empty">
                        Tidak ada data peminjaman pada periode ini.
                    </td>
                </tr>

            @endforelse

        </tbody>

    </table>


    <div class="footer">
        Dicetak pada {{ now()->format('d-m-Y H:i') }}
    </div>

</body>

</html>