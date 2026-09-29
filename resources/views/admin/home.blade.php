<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Home</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-black flex flex-col">

    {{-- IEU NAVBAR --}}
    <header class="px-4 pt-4 sm:px-6 sm:pt-6 lg:px-9 lg:pt-7 animate__animated animate__fadeInDown">

        <nav class="min-h-20 rounded-2xl bg-gray-300
               px-4 sm:px-7 lg:px-10
               flex items-center justify-between">

            {{-- ==================== MENU KIRI DESKTOP ==================== --}}
            <div class="hidden lg:flex items-center gap-8">

                <a href="#" class="border-b-2 border-black pb-1
                       text-base font-semibold tracking-wide text-black">
                    HOME
                </a>

                <a href="#" class="text-base font-semibold tracking-wide text-black
                       transition duration-200 hover:text-gray-500">
                    BUKU
                </a>

                <a href="#" class="text-base font-semibold tracking-wide text-black
                       transition duration-200 hover:text-gray-500">
                    ANGGOTA
                </a>

            </div>


            {{-- ==================== MOBILE MENU BUTTON ==================== --}}
            <button id="mobile-menu-button" type="button" class="lg:hidden flex h-10 w-10 items-center justify-center
                   text-2xl text-black" aria-label="Buka Menu" aria-expanded="false">
                ☰
            </button>


            {{-- ==================== LOGO + NAMA ==================== --}}
            <div class="flex items-center gap-2 sm:gap-3">

                {{-- Logo --}}
                <div class="h-12 w-12 shrink-0 sm:h-14 sm:w-14 lg:h-16 lg:w-16">

                    <img src="{{ asset('images/logo-kota-cimahi.png') }}" alt="Logo Kota Cimahi"
                        class="h-full w-full object-contain">

                </div>


                {{-- Nama --}}
                <div class="text-left leading-tight">

                    <p class="text-sm font-semibold text-black sm:text-base lg:text-xl">
                        Perpustakaan
                    </p>

                    <p class="text-sm font-semibold text-black sm:text-base lg:text-xl">
                        Kota Cimahi
                    </p>

                </div>

            </div>


            {{-- ==================== MENU KANAN DESKTOP ==================== --}}
            <div class="hidden lg:flex items-center gap-8">

                <a href="#" class="text-base font-semibold tracking-wide text-black
                       transition duration-200 hover:text-gray-500">
                    PEMINJAMAN
                </a>

                <a href="#" class="text-base font-semibold tracking-wide text-black
                       transition duration-200 hover:text-gray-500">
                    LAPORAN
                </a>

            </div>


            {{-- ==================== LOGOUT ==================== --}}
            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button type="submit" class="border border-black
                       px-3 py-2
                       text-sm font-semibold tracking-wide
                       text-black
                       transition duration-200
                       hover:bg-black hover:text-white
                       sm:px-5 sm:text-base">
                    LOGOUT
                </button>

            </form>

        </nav>

        {{-- ==================== MOBILE MENU ==================== --}}
        <div id="mobile-menu" class="mt-3 hidden rounded-2xl bg-gray-300 p-5 lg:hidden">

            <div class="flex flex-col gap-4">

                <a href="#" class="border-b border-gray-400 pb-3
                   text-base font-semibold tracking-wide text-black">
                    HOME
                </a>

                <a href="#" class="border-b border-gray-400 pb-3
                   text-base font-semibold tracking-wide text-black">
                    BUKU
                </a>

                <a href="#" class="border-b border-gray-400 pb-3
                   text-base font-semibold tracking-wide text-black">
                    ANGGOTA
                </a>

                <a href="#" class="border-b border-gray-400 pb-3
                   text-base font-semibold tracking-wide text-black">
                    PEMINJAMAN
                </a>

                <a href="#" class="text-base font-semibold tracking-wide text-black">
                    LAPORAN
                </a>

            </div>

        </div>

    </header>
    {{-- IEU NAVBAR END --}}

    {{-- IEU CONTENT UTAMA WEBSITE --}}
    <main class="flex-1 px-4 py-4  sm:px-6 sm:py-5 lg:px-9 lg:py-5 animate__animated animate__fadeInUp">

        <section class="rounded-2xl bg-gray-300 px-4 py-7 sm:px-7 sm:py-8 lg:px-10 lg:py-10">

            <h1 class="text-center text-2xl font-semibold tracking-[0.08em] text-black sm:text-3xl lg:text-4xl">
                PERPUSTAKAAN KOTA CIMAHI
            </h1>

            <div class="mt-8 overflow-hidden rounded-xl bg-gray-200">
                <img src="{{asset('images/perpustakaan-cimahi.png')}}" alt="Perpustakaan Kota Cimahi"
                    class="h-60 w-full object-cover transition duration-500 hover:scale-105 sm:h-80 lg:h-112.5 animate__animated animate__zoomIn">
            </div>

            <div class="mt-10 text-center">
                <p class="text-xs font-semibold tracking-[0.3em] text-gray-500 sm:text-sm">ADMIN PANEL</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-[0.08em] text-black sm:text-3xl lg:text-4xl">ADMIN
                    ACCESS
                </h2>
                <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-gray-600 sm:text-base">
                    Kelola dan Akses Data Perpustakaan Kota Cimahi melalui Panel Administrasi
                </p>
                <button id="data-button" type="button"
                    class="mt-7 border border-black px-12 py-3 text-lg font-semibold tracking-wide text-black transition-all duration-300 hover:-translate-y-1 hover:bg-black hover:text-white hover:shadow-lg active:translate-y-0 active:scale-95 sm:px-16 sm:text-2xl">
                    DATA
                </button>
            </div>

        </section>

    </main>
    {{-- IEU CONTENT UTAMA WEBSITE END --}}


    {{-- ==================== FOOTER ==================== --}}
    <footer class="px-4 pb-4 sm:px-6 sm:pb-6 lg:px-9 lg:pb-7 animate__animated animate__fadeInUp">

        <div class="min-h-40 rounded-2xl bg-gray-300
               px-5 py-7
               flex flex-col items-center justify-center
               text-center
               sm:min-h-48 sm:px-10 sm:py-8">

            <h2 class="text-lg font-semibold tracking-wide text-black sm:text-2xl">
                PERPUSTAKAAN KOTA CIMAHI
            </h2>

            <p class="mt-2 text-sm text-gray-600 sm:mt-3 sm:text-base">
                Sistem Informasi Perpustakaan Kota Cimahi
            </p>

            <p class="mt-5 text-xs text-gray-500 sm:mt-6 sm:text-sm">
                © 2026 Perpustakaan Kota Cimahi
            </p>

        </div>

    </footer>

    {{-- ==================== DATA ACCESS MODAL ==================== --}}
    <div id="data-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4">

        {{-- ==================== CLOSE BUTTON ==================== --}}
        <button id="close-data-modal" type="button" aria-label="Tutup popup" class="absolute right-4 top-4
               flex h-10 w-10 items-center justify-center
               border-2 border-black
               bg-white
               text-2xl font-bold text-black
               transition duration-200
               hover:bg-black hover:text-white
               active:scale-95
               sm:right-6 sm:top-6">
            ×
        </button>

        {{-- ==================== PASSWORD POPUP ==================== --}}
        <div id="password-step"
            class="w-full max-w-3xl rounded-xl border-2 border-black bg-white px-6 py-10 text-center shadow-xl sm:px-10 sm:py-12">

            {{-- Judul --}}
            <div class="mx-auto -mt-20 w-fit border-2 border-black bg-white px-5 py-2 sm:px-7">
                <h2 class="text-3xl font-bold tracking-wide sm:text-5xl">
                    MASSAGE
                </h2>
            </div>

            {{-- Deskripsi --}}
            <p class="mx-auto mt-8 max-w-2xl text-xl font-semibold leading-relaxed sm:text-2xl">
                You must enter the password to access
                the data management page!
            </p>

            {{-- Password --}}
            <input id="data-password" type="password" placeholder="enter the password..." class="mt-6 w-full border-2 border-black
                   px-4 py-3
                   text-center text-xl font-semibold
                   outline-none
                   placeholder:text-gray-500
                   focus:ring-2 focus:ring-black
                   sm:text-2xl">

            <p id="password-error" class="mt-3 hidden text-sm font-semibold text-red-600">Password yang anda masukkan
                salah. Silahkan coba lagi.
            </p>

            {{-- Enter --}}
            <button id="password-enter-button" type="button" class="mt-7 border-2 border-black
                   px-5 py-2
                   text-2xl font-bold
                   transition duration-200
                   hover:bg-black hover:text-white
                   active:scale-95
                   sm:text-3xl">
                ENTER
            </button>

        </div>

        {{-- ==================== LOADING STEP ==================== --}}
        <div id="loading-step" class="hidden w-full max-w-3xl rounded-xl border-2 border-black
           bg-white px-6 py-16 text-center shadow-xl
           sm:px-10 sm:py-20">

            {{-- Judul --}}
            <div class="mx-auto -mt-24 w-fit border-2 border-black bg-white px-5 py-2 sm:px-7">
                <h2 class="text-3xl font-bold tracking-wide sm:text-5xl">
                    MASSAGE
                </h2>
            </div>

            {{-- Loading --}}
            <div class="mt-20 flex justify-center">

                <div
                    class="h-14 w-14 animate-spin rounded-full border-4 border-gray-300 border-t-black sm:h-16 sm:w-16">
                </div>

            </div>

        </div>

        {{-- ==================== DATA SELECTION STEP ==================== --}}
        <div id="data-selection-step" class="hidden w-full max-w-3xl rounded-xl border-2 border-black
           bg-white px-6 py-10 text-center shadow-xl
           sm:px-10 sm:py-12">

            {{-- Judul --}}
            <div class="mx-auto -mt-20 w-fit border-2 border-black bg-white px-5 py-2 sm:px-7">
                <h2 class="text-3xl font-bold tracking-wide sm:text-5xl">
                    MASSAGE
                </h2>
            </div>


            {{-- Deskripsi --}}
            <p class="mx-auto mt-8 max-w-2xl text-xl font-semibold leading-relaxed sm:text-2xl">
                Silahkan pilih data yang<br class="sm:hidden">
                ingin anda kelola
            </p>


            {{-- Tombol Data --}}
            <div class="mx-auto mt-8 grid max-w-2xl grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- Data Buku --}}
                <button id="data-buku-button" type="button" class="border-2 border-black
                   px-4 py-2
                   text-lg font-bold
                   transition duration-200
                   hover:bg-black hover:text-white
                   active:scale-95
                   sm:text-xl">
                    DATA BUKU
                </button>


                {{-- Data Anggota --}}
                <button id="data-anggota-button" type="button" class="border-2 border-black
                   px-4 py-2
                   text-lg font-bold
                   transition duration-200
                   hover:bg-black hover:text-white
                   active:scale-95
                   sm:text-xl">
                    DATA ANGGOTA
                </button>


                {{-- Data Peminjaman --}}
                <button id="data-peminjaman-button" type="button" class="border-2 border-black
                   px-4 py-2
                   text-lg font-bold
                   transition duration-200
                   hover:bg-black hover:text-white
                   active:scale-95
                   sm:text-xl">
                    DATA PEMINJAMAN
                </button>


                {{-- Data Laporan --}}
                <button id="data-laporan-button" type="button" class="border-2 border-black
                   px-4 py-2
                   text-lg font-bold
                   transition duration-200
                   hover:bg-black hover:text-white
                   active:scale-95
                   sm:text-xl">
                    DATA LAPORAN
                </button>

            </div>

        </div>

    </div>

</body>

</html>