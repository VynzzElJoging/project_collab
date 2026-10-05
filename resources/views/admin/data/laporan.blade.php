<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Laporan Peminjaman</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-white text-black">

    <main class="px-4 py-6 sm:px-6 lg:px-9">


        {{-- HEADER --}}

        <section class="rounded-2xl bg-gray-300 px-5 py-7 sm:px-7">

            <p class="text-sm font-semibold tracking-[0.25em] text-gray-500">
                ADMIN PANEL
            </p>

            <h1 class="mt-2 text-3xl font-semibold">
                Laporan Peminjaman
            </h1>

            <p class="mt-2 text-sm text-gray-600">
                Lihat dan export laporan peminjaman perpustakaan.
            </p>

        </section>


        {{-- FILTER --}}

        <section class="mt-6 rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">

            <form
                method="GET"
                action="{{ route('admin.data.laporan') }}"
                class="space-y-5"
            >

                <div class="grid gap-5 md:grid-cols-3">

                    {{-- JENIS LAPORAN --}}

                    <div>

                        <label
                            for="jenis"
                            class="mb-2 block text-sm font-semibold"
                        >
                            Jenis Laporan
                        </label>

                        <select
                            id="jenis"
                            name="jenis"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none focus:border-black"
                        >

                            <option
                                value="bulanan"
                                {{ $jenis === 'bulanan' ? 'selected' : '' }}
                            >
                                Bulanan
                            </option>

                            <option
                                value="tahunan"
                                {{ $jenis === 'tahunan' ? 'selected' : '' }}
                            >
                                Tahunan
                            </option>

                        </select>

                    </div>


                    {{-- BULAN --}}

                    <div id="bulan-wrapper">

                        <label
                            for="bulan"
                            class="mb-2 block text-sm font-semibold"
                        >
                            Bulan
                        </label>

                        <select
                            id="bulan"
                            name="bulan"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none focus:border-black"
                        >

                            @php
                                $namaBulan = [
                                    1 => 'Januari',
                                    2 => 'Februari',
                                    3 => 'Maret',
                                    4 => 'April',
                                    5 => 'Mei',
                                    6 => 'Juni',
                                    7 => 'Juli',
                                    8 => 'Agustus',
                                    9 => 'September',
                                    10 => 'Oktober',
                                    11 => 'November',
                                    12 => 'Desember',
                                ];
                            @endphp

                            @foreach ($namaBulan as $nomor => $nama)

                                <option
                                    value="{{ $nomor }}"
                                    {{ $bulan === $nomor ? 'selected' : '' }}
                                >
                                    {{ $nama }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- TAHUN --}}

                    <div>

                        <label
                            for="tahun"
                            class="mb-2 block text-sm font-semibold"
                        >
                            Tahun
                        </label>

                        <input
                            id="tahun"
                            name="tahun"
                            type="number"
                            min="2000"
                            max="2100"
                            value="{{ $tahun }}"
                            class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 outline-none focus:border-black"
                        >

                    </div>

                </div>


                <div class="flex flex-wrap gap-3">

                    <button
                        type="submit"
                        class="border-2 border-black bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-black"
                    >
                        Tampilkan Laporan
                    </button>

                </div>

            </form>

        </section>


        {{-- STATISTIK --}}

        <section class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">

            <div class="rounded-xl border border-gray-200 p-5 shadow-sm">

                <p class="text-sm text-gray-500">
                    Total Transaksi
                </p>

                <p class="mt-2 text-3xl font-bold">
                    {{ $statistik['total_transaksi'] }}
                </p>

            </div>


            <div class="rounded-xl border border-gray-200 p-5 shadow-sm">

                <p class="text-sm text-gray-500">
                    Total Buku
                </p>

                <p class="mt-2 text-3xl font-bold">
                    {{ $statistik['total_buku'] }}
                </p>

            </div>


            <div class="rounded-xl border border-gray-200 p-5 shadow-sm">

                <p class="text-sm text-gray-500">
                    Dikembalikan
                </p>

                <p class="mt-2 text-3xl font-bold">
                    {{ $statistik['total_dikembalikan'] }}
                </p>

            </div>


            <div class="rounded-xl border border-gray-200 p-5 shadow-sm">

                <p class="text-sm text-gray-500">
                    Masih Dipinjam
                </p>

                <p class="mt-2 text-3xl font-bold">
                    {{ $statistik['total_dipinjam'] }}
                </p>

            </div>


            <div class="rounded-xl border border-gray-200 p-5 shadow-sm">

                <p class="text-sm text-gray-500">
                    Total Denda
                </p>

                <p class="mt-2 text-xl font-bold">
                    Rp {{ number_format($statistik['total_denda'], 0, ',', '.') }}
                </p>

            </div>

        </section>


        {{-- EXPORT --}}

        <section class="mt-6 flex flex-wrap gap-3">

            <a
                href="{{ route('admin.data.laporan.pdf', request()->query()) }}"
                class="border-2 border-red-600 bg-red-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-red-600"
            >
                Export PDF
            </a>


            <a
                href="{{ route('admin.data.laporan.excel', request()->query()) }}"
                class="border-2 border-green-600 bg-green-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-green-600"
            >
                Export Excel
            </a>

        </section>


        {{-- TABEL --}}

        <section class="mt-6 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-black text-white">

                        <tr>

                            <th class="px-4 py-4 text-center">
                                No
                            </th>

                            <th class="px-4 py-4 text-left">
                                Tanggal Pinjam
                            </th>

                            <th class="px-4 py-4 text-left">
                                Anggota
                            </th>

                            <th class="px-4 py-4 text-left">
                                Buku
                            </th>

                            <th class="px-4 py-4 text-center">
                                Jumlah
                            </th>

                            <th class="px-4 py-4 text-left">
                                Jatuh Tempo
                            </th>

                            <th class="px-4 py-4 text-left">
                                Kembali
                            </th>

                            <th class="px-4 py-4 text-center">
                                Status
                            </th>

                            <th class="px-4 py-4 text-right">
                                Denda
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-gray-200">

                        @php
                            $no = 1;
                        @endphp


                        @forelse ($laporan as $peminjaman)

                            @foreach ($peminjaman->details as $detail)

                                <tr class="hover:bg-gray-50">

                                    <td class="px-4 py-4 text-center">
                                        {{ $no++ }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $peminjaman->tanggal_pinjam?->format('d-m-Y') ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4 font-medium">
                                        {{ $peminjaman->anggota->nama ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $detail->book->judul ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4 text-center">
                                        {{ $detail->jumlah }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $peminjaman->tanggal_jatuh_tempo?->format('d-m-Y') ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $peminjaman->tanggal_kembali?->format('d-m-Y') ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4 text-center">

                                        @if ($peminjaman->status === 'dikembalikan')

                                            <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                Dikembalikan
                                            </span>

                                        @else

                                            <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                                Dipinjam
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-4 py-4 text-right">
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

                                <td
                                    colspan="9"
                                    class="px-4 py-12 text-center text-gray-500"
                                >
                                    Tidak ada data peminjaman pada periode yang dipilih.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </section>


    </main>


    <script>

        const jenis = document.getElementById('jenis');
        const bulanWrapper = document.getElementById('bulan-wrapper');

        function updateBulanVisibility() {

            if (jenis.value === 'tahunan') {

                bulanWrapper.classList.add('hidden');

            } else {

                bulanWrapper.classList.remove('hidden');

            }

        }

        jenis.addEventListener('change', updateBulanVisibility);

        updateBulanVisibility();

    </script>

</body>

</html>