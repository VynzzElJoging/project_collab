<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Peminjaman</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-black">

    <main class="px-4 py-6 sm:px-6 lg:px-9">

        @if (session('success'))
            <div class="mb-6 rounded-xl border border-green-300 bg-green-50 px-5 py-4 text-green-800">
                <p class="font-semibold">
                    Berhasil
                </p>

                <p class="mt-1 text-sm">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-xl border border-red-300 bg-red-50 px-5 py-4 text-red-800">
                <p class="font-semibold">
                    Terjadi Kesalahan
                </p>

                <p class="mt-1 text-sm">
                    {{ session('error') }}
                </p>
            </div>
        @endif

        <section class="rounded-2xl bg-gray-300 px-5 py-7 sm:px-7 sm:py-8 lg:px-10 lg:py-10">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div>
                    <p class="text-sm font-semibold tracking-[0.25em] text-gray-500">
                        ADMIN PANEL
                    </p>

                    <h1 class="mt-2 text-3xl font-semibold tracking-[0.08em] sm:text-4xl lg:text-5xl">
                        DATA PEMINJAMAN
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-relaxed text-gray-600">
                        Kelola transaksi peminjaman dan pengembalian buku.
                    </p>
                </div>

                <a href="{{ route('admin.data.peminjaman.create') }}"
                    class="border-2 border-black bg-black px-5 py-3 text-center text-sm font-semibold text-white transition hover:bg-white hover:text-black">
                    + TAMBAH PEMINJAMAN
                </a>

            </div>

            {{-- SEARCH --}}
            <form action="{{ route('admin.data.peminjaman.index') }}" method="GET"
                class="mt-8 flex flex-col gap-3 sm:flex-row">

                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Cari nama anggota atau judul buku..."
                    class="flex-1 border-2 border-black bg-white px-4 py-3 text-sm outline-none">

                <button type="submit"
                    class="border-2 border-black bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-black">
                    CARI
                </button>

                @if ($search)
                    <a href="{{ route('admin.data.peminjaman.index') }}"
                        class="border-2 border-black bg-white px-6 py-3 text-center text-sm font-semibold transition hover:bg-black hover:text-white">
                        RESET
                    </a>
                @endif

            </form>

            {{-- DATA --}}
            <div class="mt-8 space-y-5">

                @forelse ($peminjamans as $peminjaman)

                    <div class="rounded-xl bg-white p-5 shadow-sm">

                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                    Anggota
                                </p>

                                <h2 class="mt-1 text-xl font-semibold">
                                    {{ $peminjaman->anggota->nama }}
                                </h2>

                                <p class="mt-3 text-sm text-gray-600">
                                    Pinjam:
                                    <strong>
                                        {{ $peminjaman->tanggal_pinjam->format('d/m/Y') }}
                                    </strong>
                                </p>

                                <p class="text-sm text-gray-600">
                                    Jatuh tempo:
                                    <strong>
                                        {{ $peminjaman->tanggal_jatuh_tempo->format('d/m/Y') }}
                                    </strong>
                                </p>

                            </div>

                            <div class="text-left lg:text-right">

                                @if ($peminjaman->status === 'dipinjam')

                                    <span
                                        class="inline-block rounded-full bg-yellow-100 px-4 py-2 text-xs font-semibold text-yellow-800">
                                        MASIH DIPINJAM
                                    </span>

                                @else

                                    <span
                                        class="inline-block rounded-full bg-green-100 px-4 py-2 text-xs font-semibold text-green-800">
                                        DIKEMBALIKAN
                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- BUKU --}}
                        <div class="mt-5 border-t border-gray-200 pt-5">

                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                Buku yang dipinjam
                            </p>

                            <div class="mt-3 space-y-2">

                                @foreach ($peminjaman->details as $detail)

                                    <div class="rounded-lg bg-gray-100 px-4 py-3">

                                        <p class="font-medium">
                                            {{ $detail->book->judul }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            {{ $detail->book->penulis }}
                                        </p>

                                    </div>

                                @endforeach

                            </div>

                        </div>

                        {{-- PENGEMBALIAN --}}
                        <div
                            class="mt-5 flex flex-col gap-3 border-t border-gray-200 pt-5 sm:flex-row sm:items-center sm:justify-between">

                            @if ($peminjaman->status === 'dikembalikan')

                                <p class="text-sm">
                                    Dikembalikan:
                                    <strong>
                                        {{ $peminjaman->tanggal_kembali->format('d/m/Y') }}
                                    </strong>
                                </p>

                                <p class="text-sm font-semibold">
                                    Denda:
                                    Rp{{ number_format($peminjaman->denda, 0, ',', '.') }}
                                </p>

                            @else

                                <p class="text-sm text-gray-500">
                                    Buku masih berada pada anggota.
                                </p>

                                <form action="{{ route('admin.data.peminjaman.kembalikan', $peminjaman) }}" method="POST"
                                    onsubmit="return confirm('Yakin buku dari transaksi ini sudah dikembalikan?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="w-full border-2 border-black bg-black px-5 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-black sm:w-auto">
                                        PROSES PENGEMBALIAN
                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                @empty

                    <div class="rounded-xl bg-white px-6 py-16 text-center">

                        <div class="text-5xl">
                            📚
                        </div>

                        <h2 class="mt-5 text-xl font-semibold">
                            DATA PEMINJAMAN TIDAK DITEMUKAN
                        </h2>

                        <p class="mt-2 text-sm text-gray-500">
                            Belum ada transaksi peminjaman.
                        </p>

                    </div>

                @endforelse

            </div>

            {{-- PAGINATION --}}
            @if ($peminjamans->hasPages())

                <div class="mt-8 border-t-2 border-black pt-6">
                    {{ $peminjamans->links() }}
                </div>

            @endif

        </section>

    </main>

</body>

</html>