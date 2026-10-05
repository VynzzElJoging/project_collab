<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Anggota</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-black">
    <main class="px-4 py-6 sm:px-6 lg:px-9">

        {{-- PESAN SUKSES --}}
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


        {{-- HEADER --}}
        <section class="rounded-2xl bg-gray-300 px-5 py-7 sm:px-7 sm:py-8 lg:px-10 lg:py-10">

            <div>
                <p class="text-sm font-semibold tracking-[0.25em] text-gray-500">
                    ADMIN PANEL
                </p>

                <h1 class="mt-2 text-3xl font-semibold tracking-[0.08em] sm:text-4xl lg:text-5xl">
                    DATA ANGGOTA
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-relaxed text-gray-600 sm:text-base">
                    Kelola daftar anggota yang ada di Perpustakaan Kota Cimahi.
                </p>
            </div>


            {{-- TOMBOL TAMBAH ANGGOTA --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.data.anggota.create') }}"
                    class="inline-flex items-center justify-center border-2 border-black bg-black px-5 py-3 text-sm font-semibold tracking-wide text-white transition-all duration-300 ease-out hover:-translate-y-1 hover:bg-white hover:text-black hover:shadow-lg active:translate-y-0 active:scale-[0.98]">
                    TAMBAH ANGGOTA
                </a>
            </div>


            {{-- SEARCH DAN SORTING --}}
            <div class="mt-6">

                <form action="{{ route('admin.data.anggota.index') }}" method="GET"
                    class="flex flex-col gap-3 sm:flex-row">

                    {{-- SEARCH --}}
                    <div class="relative flex-1">

                        <input
                            type="text"
                            name="search"
                            value="{{ $neanganDataAnggota ?? '' }}"
                            placeholder="Cari nama, email, atau jenis kelamin..."
                            class="w-full border-2 border-black bg-white px-4 py-3 pr-12 text-sm text-black outline-none transition-all duration-300 placeholder:text-gray-400 focus:bg-gray-50 focus:shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]">

                        <span
                            class="pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-lg">
                            🔍
                        </span>

                    </div>


                    {{-- TOMBOL CARI --}}
                    <button
                        type="submit"
                        class="border-2 border-black bg-black px-6 py-3 text-sm font-semibold tracking-wide text-white transition-all duration-300 hover:-translate-y-1 hover:bg-white hover:text-black hover:shadow-lg active:translate-y-0 active:scale-[0.98]">
                        CARI
                    </button>


                    {{-- TOMBOL RESET --}}
                    @if ($neanganDataAnggota ?? false || ($urutkeun ?? 'nama_asc') !== 'nama_asc')

                        <a
                            href="{{ route('admin.data.anggota.index') }}"
                            class="border-2 border-black bg-white px-6 py-3 text-center text-sm font-semibold tracking-wide text-black transition-all duration-300 hover:bg-black hover:text-white active:scale-[0.98]">
                            RESET
                        </a>

                    @endif

                </form>

            </div>


            {{-- AREA DATA ANGGOTA --}}
            <div class="mt-8 rounded-xl bg-gray-200 p-6">

                {{-- DATA ANGGOTA KOSONG --}}
                @if ($anggotas->isEmpty())

                    <div class="flex min-h-75 flex-col items-center justify-center px-6 py-12 text-center">

                        <div
                            class="flex h-16 w-16 items-center justify-center rounded-full bg-white text-3xl shadow-sm">
                            👤
                        </div>

                        <h2 class="mt-5 text-xl font-semibold tracking-wide">
                            ANGGOTA TIDAK DITEMUKAN
                        </h2>

                        <p class="mt-2 max-w-md text-sm leading-relaxed text-gray-500">
                            Belum ada data anggota yang tersimpan.
                        </p>

                        <a
                            href="{{ route('admin.data.anggota.create') }}"
                            class="mt-6 border-2 border-black bg-black px-5 py-3 text-sm font-semibold tracking-wide text-white transition-all duration-300 hover:-translate-y-1 hover:bg-white hover:text-black hover:shadow-lg active:translate-y-0 active:scale-[0.98]">
                            TAMBAH ANGGOTA
                        </a>

                    </div>

                @else

                    {{-- CARD ANGGOTA --}}
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                      @foreach ($anggotas as $anggota)

    <div
        class="group cursor-pointer overflow-hidden rounded-xl bg-white shadow-sm transition-all duration-300 ease-out hover:-translate-y-2 hover:shadow-2xl active:scale-[0.98]">

        {{-- HEADER CARD --}}
        <div class="bg-black px-5 py-6 text-white">

            <div class="flex h-16 w-16 items-center justify-center overflow-hidden rounded-full bg-white text-2xl text-black">
                @if ($anggota->foto)
                    <img
                        src="{{ asset('storage/' . $anggota->foto) }}"
                        alt="Foto {{ $anggota->nama }}"
                        class="h-full w-full object-cover"
                    >
                @else
                    👤
                @endif
            </div>

            <h2 class="mt-4 text-xl font-semibold tracking-wide">
                {{ $anggota->nama }}
            </h2>

            <p class="mt-1 text-sm text-gray-300">
                {{ $anggota->email ?? 'Email belum tersedia' }}
            </p>

        </div>

                                {{-- INFORMASI ANGGOTA --}}
                                <div class="p-5">

                                    <div class="space-y-3">

                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                Tanggal Lahir
                                            </p>

                                            <p class="mt-1 text-sm font-medium">
                                                {{ $anggota->tanggal_lahir ?? 'Belum diisi' }}
                                            </p>
                                        </div>


                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                Jenis Kelamin
                                            </p>

                                            <p class="mt-1 text-sm font-medium">
                                                {{ $anggota->jenis_kelamin ?? 'Belum diisi' }}
                                            </p>
                                        </div>


                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                No. HP
                                            </p>

                                            <p class="mt-1 text-sm font-medium">
                                                {{ $anggota->no_hp ?? 'Belum diisi' }}
                                            </p>
                                        </div>


                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                Alamat
                                            </p>

                                            <p class="mt-1 text-sm leading-relaxed">
                                                {{ $anggota->alamat ?? 'Belum diisi' }}
                                            </p>
                                        </div>

                                    </div>


                                    {{-- TOMBOL EDIT --}}
                                    <div class="mt-5">

                                        <a
                                            href="{{ route('admin.data.anggota.edit', $anggota) }}"
                                            class="block w-full border-2 border-black px-4 py-2.5 text-center text-sm font-semibold tracking-wide transition-all duration-300 hover:bg-black hover:text-white active:scale-[0.98]">
                                            EDIT
                                        </a>

                                    </div>


                                    {{-- TOMBOL DELETE --}}
                                    <div class="mt-3">

                                        <form
                                            action="{{ route('admin.data.anggota.destroy', $anggota) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="block w-full border-2 border-black bg-white px-4 py-2.5 text-center text-sm font-semibold tracking-wide transition-all duration-300 hover:bg-black hover:text-white active:scale-[0.98]">

                                                DELETE

                                            </button>

                                        </form>
                                        

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @endif

            </div>

        </section>

    </main>

</body>

</html>