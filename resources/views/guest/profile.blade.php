<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Anggota</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-950 text-white">

    @php
        $anggota = Auth::user()->anggota;
    @endphp

    <div class="mx-auto max-w-3xl px-6 py-10">

        {{-- ================= CARD PROFILE ================= --}}
        <div class="rounded-2xl border border-green-500/30 bg-slate-900 p-8 shadow-xl">

            {{-- ================= HEADER ================= --}}
            <div class="mb-8 flex items-center justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-green-400">
                        Profil Anggota
                    </h1>

                    <p class="mt-1 text-sm text-gray-400">
                        Lengkapi data diri kamu
                    </p>
                </div>

                {{-- Tombol kembali hanya muncul kalau data anggota sudah ada --}}
                @if ($anggota)
                    <a
                        href="{{ route('guest.home') }}"
                        class="rounded-lg bg-gray-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-gray-600"
                    >
                        ← Kembali
                    </a>
                @endif

            </div>


            {{-- ================= FOTO PROFILE ================= --}}
            <div class="mb-8 flex justify-center">

                <div class="relative h-32 w-32">

                    {{-- Foto --}}
                    <div
                        class="flex h-32 w-32 items-center justify-center overflow-hidden rounded-full bg-green-500 text-4xl font-bold"
                    >

                        @if ($anggota && $anggota->foto)

                            <img
                                src="{{ asset('storage/' . $anggota->foto) }}"
                                alt="Foto {{ $anggota->nama }}"
                                class="h-full w-full object-cover"
                            >

                        @else

                            {{ strtoupper(substr($anggota->nama ?? Auth::user()->username, 0, 1)) }}

                        @endif

                    </div>


                    {{-- ================= TOMBOL KAMERA ================= --}}
                    @if ($anggota)

                        <form
                            action="{{ route('guest.profile.foto') }}"
                            method="POST"
                            enctype="multipart/form-data"
                            class="absolute bottom-0 right-0"
                        >

                            @csrf

                            <label
                                for="foto"
                                class="flex h-10 w-10 cursor-pointer items-center justify-center rounded-full bg-green-500 text-xl shadow-lg ring-4 ring-slate-900 transition hover:bg-green-400"
                            >
                                📷
                            </label>

                            <input
                                type="file"
                                id="foto"
                                name="foto"
                                accept="image/*"
                                class="hidden"
                                onchange="this.form.submit()"
                            >

                        </form>

                    @endif

                </div>

            </div>


            {{-- ================= NAMA ================= --}}
            <div class="mb-8 text-center">

                <h2 class="text-3xl font-bold text-green-400">
                    {{ $anggota->nama ?? 'Lengkapi Profil' }}
                </h2>

                <p class="mt-1 text-gray-400">
                    Anggota
                </p>

            </div>


            {{-- ================= FORM DATA ================= --}}
            <form
                action="{{ route('guest.profile.update') }}"
                method="POST"
                class="space-y-5"
            >

                @csrf


                {{-- ================= NAMA LENGKAP ================= --}}
                <div>

                    <label
                        for="nama"
                        class="mb-2 block text-sm font-medium text-gray-300"
                    >
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $anggota->nama ?? '') }}"
                        placeholder="Masukkan nama lengkap"
                        class="w-full rounded-xl border border-gray-700 bg-slate-800 px-4 py-3 text-white outline-none transition focus:border-green-500"
                    >

                    @error('nama')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================= EMAIL ================= --}}
                <div>

                    <label
                        for="email"
                        class="mb-2 block text-sm font-medium text-gray-300"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $anggota->email ?? '') }}"
                        placeholder="Masukkan email"
                        class="w-full rounded-xl border border-gray-700 bg-slate-800 px-4 py-3 text-white outline-none transition focus:border-green-500"
                    >

                    @error('email')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================= TANGGAL LAHIR ================= --}}
                <div>

                    <label
                        for="tanggal_lahir"
                        class="mb-2 block text-sm font-medium text-gray-300"
                    >
                        Tanggal Lahir
                    </label>

                    <input
                        type="date"
                        id="tanggal_lahir"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', $anggota->tanggal_lahir ?? '') }}"
                        class="w-full rounded-xl border border-gray-700 bg-slate-800 px-4 py-3 text-white outline-none transition focus:border-green-500"
                    >

                    @error('tanggal_lahir')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================= JENIS KELAMIN ================= --}}
                <div>

                    <label
                        for="jenis_kelamin"
                        class="mb-2 block text-sm font-medium text-gray-300"
                    >
                        Jenis Kelamin
                    </label>

                    <select
                        id="jenis_kelamin"
                        name="jenis_kelamin"
                        class="w-full rounded-xl border border-gray-700 bg-slate-800 px-4 py-3 text-white outline-none transition focus:border-green-500"
                    >

                        <option value="">
                            Pilih jenis kelamin
                        </option>

                        <option
                            value="Laki-laki"
                            {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}
                        >
                            Laki-laki
                        </option>

                        <option
                            value="Perempuan"
                            {{ old('jenis_kelamin', $anggota->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}
                        >
                            Perempuan
                        </option>

                    </select>

                    @error('jenis_kelamin')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================= ALAMAT ================= --}}
                <div>

                    <label
                        for="alamat"
                        class="mb-2 block text-sm font-medium text-gray-300"
                    >
                        Alamat
                    </label>

                    <textarea
                        id="alamat"
                        name="alamat"
                        rows="4"
                        placeholder="Masukkan alamat lengkap"
                        class="w-full rounded-xl border border-gray-700 bg-slate-800 px-4 py-3 text-white outline-none transition focus:border-green-500"
                    >{{ old('alamat', $anggota->alamat ?? '') }}</textarea>

                    @error('alamat')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================= NO HP ================= --}}
                <div>

                    <label
                        for="no_hp"
                        class="mb-2 block text-sm font-medium text-gray-300"
                    >
                        No HP
                    </label>

                    <input
                        type="text"
                        id="no_hp"
                        name="no_hp"
                        value="{{ old('no_hp', $anggota->no_hp ?? '') }}"
                        placeholder="Contoh: 08123456789"
                        class="w-full rounded-xl border border-gray-700 bg-slate-800 px-4 py-3 text-white outline-none transition focus:border-green-500"
                    >

                    @error('no_hp')
                        <p class="mt-2 text-sm text-red-400">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- ================= TOMBOL SIMPAN ================= --}}
                <div class="pt-4">

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-green-500 px-5 py-3 font-bold text-slate-950 transition hover:bg-green-400"
                    >
                        Simpan Data
                    </button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>