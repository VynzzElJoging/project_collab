<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Buku</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-black">
    <main class="px-4 py-6 sm:px-6 lg:px-9">

        {{-- IEU PESAN SUKSES JANG CUD DATA --}}
        @if (session('success'))
            <div class="mb-6 flex items-center justify-between gap-4 rounded-xl border border-green-300 bg-green-50 px-5 py-4 text-green-800 shadow-sm">
                <div class="flex items-center gap-3">

                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-green-600 text-sm font-bold text-white">
                        ✓
                    </span>

                    <div>
                        <p class="font-semibold">
                            Berhasil
                        </p>

                        <p class="text-sm">
                            {{ session('success') }}
                        </p>
                    </div>

                </div>
            </div>
        @endif

        <section class="rounded-2xl bg-gray-300 px-5 py-7 sm:px-7 sm:py-8 lg:px-10 lg:py-10">
            {{-- IEU JANG JUDUL --}}
            <div>
                <p class="text-sm font-semibold tracking-[0.25em] text-gray-500">
                    ADMIN PANEL
                </p>

                <h1 class="mt-2 text-3xl font-semibold tracking-[0.08em] sm:text-4xl lg:text-5xl">
                    DATA BUKU
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-relaxed text-gray-600 sm:text-base">
                    Kelola koleksi buku yang tersedia di Perpustakaan Kota Cimahi.
                </p>
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.data.buku.create') }}" class="inline-flex items-center justify-center border-2 border-black bg-black px-5 py-3 text-sm font-semibold tracking-wide text-white transition-all duration-300 ease-out hover:-translate-y-1 hover:bg-white hover:text-black hover:shadow-lg active:translate-y-0 active:scale-[0.98]">
                    + TAMBAH BUKU
                </a>
            </div>

            {{-- IEU JANG SEARCHING, FILTERING, SORTING --}}
            <div class="mt-6">
                <form action="{{ route('admin.data.buku.index') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
                    {{-- IEU JANG SEARCH BERDASARKAN JUDUL, PENULIS PENERBIT--}}
                    <div class="relative flex-1">
                        <input type="text" name="search" value="{{ $neanganDataBuku ?? '' }}"
                                    placeholder="Cari judul, penulis, atau penerbit..." class="w-full border-2 border-black bg-white px-4 py-3 pr-12 text-sm text-black outline-none transition-all duration-300 placeholder:text-gray-400 focus:bg-gray-50 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <span class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-lg">
                            🔍
                        </span>
                    </div>

                    {{-- IEU JANG FILTERING BERDASARKAN KATEGORI --}}
                    <select name="kategori" class="border-2 border-black bg-white px-4 py-3 text-sm text-black outline-none transition-all duration-300 focus:bg-gray-50 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <option value="">
                            Semua Kategori
                        </option>

                        @foreach ($kategoris as $category)
                            <option value="{{ $category }}" {{ $filterKategori === $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>

                    {{-- IEU JANG SORTING --}}
                    <select name="sort" class="border-2 border-black bg-white px-4 py-3 text-sm text-black outline-none transition-all duration-300 focus:bg-gray-50 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">
                        <option value="judul_asc" {{ ($urutkeun ?? 'judul_asc') === 'judul_asc' ? 'selected' : '' }}>
                            Judul A → Z
                        </option>

                        <option value="judul_desc" {{ ($urutkeun ?? 'judul_asc') === 'judul_desc' ? 'selected' : '' }}>
                            Judul Z → A
                        </option>

                        <option value="tahun_asc" {{ ($urutkeun ?? 'judul_asc') === 'tahun_asc' ? 'selected' : '' }}>
                            Tahun Terlama → Terbaru
                        </option>

                        <option value="tahun_desc" {{ ($urutkeun ?? 'judul_asc') === 'tahun_desc' ? 'selected' : '' }}>
                            Tahun Terbaru → Terlama
                        </option>

                        <option value="stok_asc" {{ ($urutkeun ?? 'judul_asc') === 'stok_asc' ? 'selected' : '' }}>
                            Stok Terendah → Tertinggi
                        </option>

                        <option value="stok_desc" {{ ($urutkeun ?? 'judul_asc') === 'stok_desc' ? 'selected' : '' }}>
                            Stok Tertinggi → Terendah
                        </option>
                    </select>

                    {{-- TOMBOL CARI --}}
                    <button type="submit" class="border-2 border-black bg-black px-6 py-3 text-sm font-semibold tracking-wide text-white transition-all duration-300 hover:-translate-y-1 hover:bg-white hover:text-black hover:shadow-lg active:translate-y-0 active:scale-[0.98]">
                        CARI
                    </button>

                    {{-- TOMBOL RESET HANYA MUNCUL KETIKA USER SDANG MENGGUNAKAN FITUR SEARCH, SORTING ATAU NGURUTKEUN DATA --}}
                    @if ($neanganDataBuku || $filterKategori || ($urutkeun ?? 'judul_asc') !== 'judul_asc')
                        <a href="{{ route('admin.data.buku.index') }}" class="border-2 border-black bg-white px-6 py-3 text-center text-sm font-semibold tracking-wide text-black transition-all duration-300 hover:bg-black hover:text-white active:scale-[0.98]">
                            RESET
                        </a>
                    @endif
                </form>
            </div>

            {{-- IEU AREA JANG DATA BUKU --}}
            <div class="mt-8 rounded-xl bg-gray-200 p-6">

                {{-- IEU LAMUN DATA BUKU KOSONG ATAU TIDAK DITEMUKAN (EMPTY STATE) --}}
                @if ($tempatNyimpenDataBukus->isEmpty())
                    <div class="flex min-h-75 flex-col items-center justify-center px-6 py-12 text-center">

                        <div class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-3xl shadow-sm">
                            📚
                        </div>

                        <h2 class="mt-5 text-xl font-semibold tracking-wide">
                            BUKU TIDAK DITEMUKAN
                        </h2>

                        <p class="mt-2 max-w-md text-sm leading-relaxed text-gray-500">
                            Tidak ada buku yang sesuai dengan pencarian
                            atau filter kategori yang dipilih.
                        </p>

                        <a href="{{ route('admin.data.buku.index') }}" class="mt-6 border-2 border-black bg-black px-5 py-3 text-sm font-semibold tracking-wide text-white transition-all duration-300 hover:-translate-y-1 hover:bg-white hover:text-black hover:shadow-lg active:translate-y-0 active:scale-[0.98]">
                            RESET FILTER
                        </a>

                    </div>

                @else
                    {{-- IEU LAMUN AYAAN DATA BUKUNA --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach ($tempatNyimpenDataBukus as $book)

                        {{-- IEU JANG MARIKSA COVER TINA BOOK AYAAN ATAU HEUNTEU, JEUNG MARIKSA TI MANA SUMBER COVER NA (EKSTERNAL URL ATAU INTERNAL STORAGE) --}}
                                        @php
                                            $coverUrl = asset('images/book-placeholder.jpg');

                                            if ($book->cover) {

                                                if (
                                                    str_starts_with($book->cover, 'http://') ||
                                                    str_starts_with($book->cover, 'https://')
                                                ) {
                                                    $coverUrl = $book->cover;
                                                } else {
                                                    $coverUrl = asset('storage/' . ltrim($book->cover, '/'));
                                                }
                                            }
                                        @endphp

                                            {{-- IEU JANG CARD BUKU --}}
                                        <div class="book-card group cursor-pointer overflow-hidden rounded-xl bg-white shadow-sm transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-2xl active:scale-[0.98]"
                                            data-judul="{{ $book->judul }}" 
                                            data-penulis="{{ $book->penulis }}"
                                            data-penerbit="{{ $book->penerbit }}"
                                            data-tahun="{{ $book->tahun }}"
                                            data-kategori="{{ $book->kategori }}"
                                            data-stok="{{ $book->stok }}"
                                            data-cover="{{ $coverUrl }}">
                                            {{-- IEU COVER --}}
                                            <div class="h-120 overflow-hidden bg-gray-100">
                                                <img src="{{ $coverUrl }}" alt="Cover {{ $book->judul }}"
                                                    onerror="this.onerror=null; this.src='{{ asset('images/book-placeholder.jpg') }}';"
                                                    class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover:scale-105 group-hover:opacity-90">
                                            </div>

                                            {{--IEU INFORMAI --}}
                                            <div
                                                class="p-5 transition-transform duration-300 group-hover:translate-x-1">
                                                <h2 class="text-xl font-semibold tracking-wide">
                                                    {{ $book->judul }}
                                                </h2>
                                                <p class="mt-2 text-sm text-gray-500">
                                                    {{ $book->penulis }}
                                                </p>
                                                <div class="mt-4 flex items-center justify-between">

                                                    <span class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                        {{ $book->kategori }}
                                                    </span>

                                                    <span class="text-sm font-semibold">
                                                        Stok: {{ $book->stok }}
                                                    </span>

                                                </div>

                                                <div class="mt-5">
                                                    <a href="{{ route('admin.data.buku.edit', $book) }}" class="block w-full border-2 border-black px-4 py-2.5 text-center text-sm font-semibold tracking-wide transition-all duration-300 hover:bg-black hover:text-white active:scale-[0.98]"
                                                        onclick="event.stopPropagation()">
                                                        EDIT
                                                    </a>
                                                </div>

                                                <div class="mt-3">
                                                    <form action="{{ route('admin.data.buku.destroy', $book) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="block w-full border-2 border-black bg-white px-4 py-2.5 text-center text-sm font-semibold tracking-wide transition-all duration-300 hover:bg-black hover:text-white active:scale-[0.98]"
                                                            onclick="event.stopPropagation()">
                                                            DELETE
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>

                                        </div>

                        @endforeach

                    </div>

                    {{-- IEU JANG FITUR PAGINATION. NGECEK LAMUN SI DATA BUKU PUNYA HALAMAN --}}
                    @if ($tempatNyimpenDataBukus->hasPages())
                        <div class="mt-8 flex flex-col items-center justify-between gap-4 border-t-2 border-black pt-6 sm:flex-row">
                            {{-- INFORMASI DATA JANG PAGINATION --}}
                            <p class="text-sm font-medium text-gray-600 text-center sm:text-left">
                                Menampilkan
                                <span class="font-bold text-black">
                                    {{ $tempatNyimpenDataBukus->firstItem() }}
                                </span>
                                -
                                <span class="font-bold text-black">
                                    {{ $tempatNyimpenDataBukus->lastItem() }}
                                </span>
                                dari
                                <span class="font-bold text-black">
                                    {{ $tempatNyimpenDataBukus->total() }}
                                </span>
                                buku
                            </p>

                            {{-- NAVIGATION --}}
                            <div class="flex max-w-full items-center gap-2 overflow-x-auto pb-1">

                                {{-- SEBELUMNYA --}}
                                @if ($tempatNyimpenDataBukus->onFirstPage())

                                    <span class="border-2 border-gray-300
                                                   px-4 py-2
                                                   text-sm font-semibold
                                                   text-gray-400">
                                        ← SEBELUMNYA
                                    </span>

                                @else

                                    <a href="{{ $tempatNyimpenDataBukus->previousPageUrl() }}" class="border-2 border-black
                                                   bg-white px-4 py-2
                                                   text-sm font-semibold
                                                   text-black
                                                   transition-all duration-300
                                                   hover:-translate-y-1
                                                   hover:bg-black hover:text-white
                                                   hover:shadow-md">
                                        ← SEBELUMNYA
                                    </a>

                                @endif


                                {{-- NOMOR HALAMAN --}}
                                @foreach ($tempatNyimpenDataBukus->getUrlRange(1, $tempatNyimpenDataBukus->lastPage()) as $page => $url)

                                    @if ($page == $tempatNyimpenDataBukus->currentPage())

                                        <span class="flex h-10 min-w-10 items-center justify-center
                                                           border-2 border-black
                                                           bg-black px-3
                                                           text-sm font-bold
                                                           text-white">
                                            {{ $page }}
                                        </span>

                                    @else

                                        <a href="{{ $url }}" class="flex h-10 min-w-10 items-center justify-center
                                                           border-2 border-black
                                                           bg-white px-3
                                                           text-sm font-semibold
                                                           text-black
                                                           transition-all duration-300
                                                           hover:-translate-y-1
                                                           hover:bg-black hover:text-white
                                                           hover:shadow-md">
                                            {{ $page }}
                                        </a>

                                    @endif

                                @endforeach


                                {{-- BERIKUTNYA --}}
                                @if ($tempatNyimpenDataBukus->hasMorePages())

                                    <a href="{{ $tempatNyimpenDataBukus->nextPageUrl() }}" class="border-2 border-black
                                                   bg-white px-4 py-2
                                                   text-sm font-semibold
                                                   text-black
                                                   transition-all duration-300
                                                   hover:-translate-y-1
                                                   hover:bg-black hover:text-white
                                                   hover:shadow-md">
                                        BERIKUTNYA →
                                    </a>

                                @else

                                    <span class="border-2 border-gray-300
                                                   px-4 py-2
                                                   text-sm font-semibold
                                                   text-gray-400">
                                        BERIKUTNYA →
                                    </span>

                                @endif

                            </div>

                        </div>
                    @endif

                @endif
            </div>
        </section>
    </main>

    {{-- IEU MODAL DETAIL, LAMUN SI CRAD MEUNANG EVENT CLICK --}}
    <div id="book-detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto bg-black/50 px-4 py-6 opacity-0 transition-opacity duration-300 sm:px-6">

        <div id="book-detail-content" class="relative my-auto max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-2xl border-2 border-black bg-white p-6 shadow-2xl opacity-0 translate-y-4 scale-95 trasnsition-all duration-300 ease-out sm:p-8 lg:p-10">

            <button id="close-book-modal" type="button" aria-label="Tutup detail buku" class="absolute right-3 top-3 flex h-10 w-10 items-center justify-center border-2 border-black bg-white text-2xl font-bold text-black transition duration-200 hover:bg-black hover:text-white active:scale-95 sm:right-4 sm:top-4">
                ×
            </button>

            {{-- IEU ISI CARD--}}
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">

                <div class="flex justify-center">

                    <div class="w-full max-w-xs overflow-hidden rounded-xl bg-gray-100">
                        <img id="modal-book-cover" src="" alt="Cover buku"
                            class="h-80 w-full object-cover sm:h-96 lg:h-112">
                    </div>

                </div>

                {{-- IEU DETAIL BUKU ANU DI KLIK --}}
                <div class="flex flex-col justify-center">

                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-gray-500">
                        DETAIL BUKU
                    </p>

                    <h2 id="modal-book-title" class="mt-3 text-3xl font-semibold tracking-wide sm:text-4xl">
                        -
                    </h2>

                    <div class="mt-6">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Penulis
                        </p>

                        <p id="modal-book-author" class="mt-1 text-base font-medium">
                            -
                        </p>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Penerbit
                        </p>

                        <p id="modal-book-publisher" class="mt-1 text-base font-medium">
                            -
                        </p>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Tahun Terbit
                        </p>

                        <p id="modal-book-year" class="mt-1 text-base font-medium">
                            -
                        </p>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Kategori
                        </p>

                        <p id="modal-book-category" class="mt-1 text-base font-medium">
                            -
                        </p>
                    </div>

                    <div class="mt-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Stok
                        </p>

                        <p id="modal-book-stock" class="mt-1 text-base font-semibold">
                            -
                        </p>
                    </div>

                    {{-- IEU TOMBOL TUTUP --}}
                    <button id="close-book-modal-bottom" type="button" class="mt-8 w-full border-2 border-black bg-black px-5 py-3 text-sm font-semibold tracking-wide text-white transition duration-300 hover:bg-white hover:text-black active:scale-95">
                        TUTUP
                    </button>

                </div>

            </div>

        </div>

    </div>
</body>

</html>