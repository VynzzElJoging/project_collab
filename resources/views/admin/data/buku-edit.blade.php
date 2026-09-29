<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Buku</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-950 text-gray-50 antialiased">

    <main class="flex min-h-screen items-center justify-center px-4 py-10">

        <div class="w-full max-w-3xl">

            <div class="mb-8">

                <a href="{{ route('admin.data.buku.index') }}" class="text-sm font-semibold uppercase tracking-wider
                           text-gray-400
                           transition duration-200
                           hover:text-white">
                    ← Kembali ke Data Buku
                </a>

                <h1 class="mt-4 text-4xl font-semibold tracking-wide">
                    Edit Buku
                </h1>

                <p class="mt-2 text-sm text-gray-400">
                    Perbarui informasi buku yang tersimpan di perpustakaan.
                </p>

            </div>


            <div class="rounded-2xl border border-gray-800
                       bg-gray-900 p-6 shadow-2xl
                       sm:p-8">

                <form action="{{ route('admin.data.buku.update', $book) }}" enctype="multipart/form-data" method="POST" class="space-y-6"
                    onsubmit="return confirm('Apakah anda yakin ingin mengubah data buku ini?')">

                    @csrf

                    @method('PUT')


                    {{-- JUDUL --}}
                    <div>

                        <label for="judul" class="block text-sm font-semibold text-gray-200">
                            Judul Buku
                        </label>

                        <input type="text" id="judul" name="judul" value="{{ old('judul', $book->judul) }}" required
                            class="mt-2 w-full rounded-xl border border-gray-700
                                   bg-gray-950 px-4 py-3 text-white
                                   outline-none
                                   transition duration-200
                                   focus:border-white
                                   focus:ring-2 focus:ring-white/20">

                        @error('judul')
                            <p class="mt-2 text-sm text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- PENULIS --}}
                    <div>

                        <label for="penulis" class="block text-sm font-semibold text-gray-200">
                            Penulis
                        </label>

                        <input type="text" id="penulis" name="penulis" value="{{ old('penulis', $book->penulis) }}"
                            required class="mt-2 w-full rounded-xl border border-gray-700
                                   bg-gray-950 px-4 py-3 text-white
                                   outline-none
                                   transition duration-200
                                   focus:border-white
                                   focus:ring-2 focus:ring-white/20">

                        @error('penulis')
                            <p class="mt-2 text-sm text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- PENERBIT --}}
                    <div>

                        <label for="penerbit" class="block text-sm font-semibold text-gray-200">
                            Penerbit
                        </label>

                        <input type="text" id="penerbit" name="penerbit" value="{{ old('penerbit', $book->penerbit) }}"
                            required class="mt-2 w-full rounded-xl border border-gray-700
                                   bg-gray-950 px-4 py-3 text-white
                                   outline-none
                                   transition duration-200
                                   focus:border-white
                                   focus:ring-2 focus:ring-white/20">

                        @error('penerbit')
                            <p class="mt-2 text-sm text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- TAHUN --}}
                    <div>

                        <label for="tahun" class="block text-sm font-semibold text-gray-200">
                            Tahun Terbit
                        </label>

                        <input type="number" id="tahun" name="tahun" value="{{ old('tahun', $book->tahun) }}" required
                            min="1000" max="{{ date('Y') }}" class="mt-2 w-full rounded-xl border border-gray-700
                                   bg-gray-950 px-4 py-3 text-white
                                   outline-none
                                   transition duration-200
                                   focus:border-white
                                   focus:ring-2 focus:ring-white/20">

                        @error('tahun')
                            <p class="mt-2 text-sm text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- KATEGORI --}}
                    <div>

                        <label for="kategori" class="block text-sm font-semibold text-gray-200">
                            Kategori
                        </label>

                        <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $book->kategori) }}"
                            required class="mt-2 w-full rounded-xl border border-gray-700
                                   bg-gray-950 px-4 py-3 text-white
                                   outline-none
                                   transition duration-200
                                   focus:border-white
                                   focus:ring-2 focus:ring-white/20">

                        @error('kategori')
                            <p class="mt-2 text-sm text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- STOK --}}
                    <div>

                        <label for="stok" class="block text-sm font-semibold text-gray-200">
                            Stok
                        </label>

                        <input type="number" id="stok" name="stok" value="{{ old('stok', $book->stok) }}" required
                            min="0" class="mt-2 w-full rounded-xl border border-gray-700
                                   bg-gray-950 px-4 py-3 text-white
                                   outline-none
                                   transition duration-200
                                   focus:border-white
                                   focus:ring-2 focus:ring-white/20">

                        @error('stok')
                            <p class="mt-2 text-sm text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                    {{-- COVER --}}
                    <div>

                        {{-- JUDUL --}}
                        <label class="block text-sm font-semibold text-gray-200">
                            Cover Buku
                        </label>

                        <p class="mt-1 text-sm text-gray-400">
                            Kelola cover buku yang sedang digunakan.
                        </p>


                        {{-- COVER SAAT INI --}}
                        <div class="mt-4">

                            <p class="text-sm font-semibold text-gray-200">
                                Cover Saat Ini
                            </p>

                            <div class="mt-3 w-40 overflow-hidden rounded-xl border border-gray-700
                    bg-gray-950">

                                <img src="{{ filter_var($book->cover, FILTER_VALIDATE_URL)
    ? $book->cover
    : asset($book->cover) }}" alt="Cover {{ $book->judul }}" class="h-56 w-full object-cover">

                            </div>

                        </div>


                        {{-- PILIH SUMBER COVER --}}
                        <div class="mt-6 space-y-3">

                            {{-- PERTAHANKAN / LOCAL --}}
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl
                      border border-gray-700 bg-gray-950 px-4 py-3
                      transition duration-200 hover:border-gray-500">

                                <input type="radio" name="cover_source" value="local" {{ old('cover_source', 'local') === 'local' ? 'checked' : '' }} class="h-4 w-4">

                                <div>
                                    <p class="text-sm font-semibold text-white">
                                        Upload Cover Lokal
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Upload cover baru dari perangkat.
                                    </p>
                                </div>

                            </label>


                            {{-- EXTERNAL --}}
                            <label class="flex cursor-pointer items-center gap-3 rounded-xl
                      border border-gray-700 bg-gray-950 px-4 py-3
                      transition duration-200 hover:border-gray-500">

                                <input type="radio" name="cover_source" value="external"
                                    {{old('cover_source') === 'external' ? 'checked' : '' }} class="h-4 w-4">

                                <div>
                                    <p class="text-sm font-semibold text-white">
                                        Gunakan URL Eksternal
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Ganti cover dengan gambar dari internet.
                                    </p>
                                </div>

                            </label>

                        </div>


                        {{-- INPUT FILE LOKAL --}}
                        <div id="cover-local-field" class="mt-5">

                            <label for="cover_file" class="block text-sm font-semibold text-gray-200">
                                File Cover Baru
                            </label>

                            <input type="file" id="cover_file" name="cover_file"
                                accept="image/jpeg,image/png,image/webp" class="mt-2 block w-full cursor-pointer rounded-xl border border-gray-700
                   bg-gray-950 text-sm text-gray-300
                   file:mr-4 file:border-0
                   file:bg-white file:px-4 file:py-3
                   file:text-sm file:font-semibold
                   file:text-black
                   hover:file:bg-gray-200
                   focus:outline-none">

                            <p class="mt-2 text-xs text-gray-500">
                                Kosongkan jika tidak ingin mengganti cover saat ini.
                            </p>

                            @error('cover_file')
                                <p class="mt-2 text-sm text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- INPUT URL EKSTERNAL --}}
                        <div id="cover-external-field" class="mt-5 hidden">

                            <label for="cover_url" class="block text-sm font-semibold text-gray-200">
                                URL Cover Baru
                            </label>

                            <input type="url" id="cover_url" name="cover_url" value="{{ old('cover_url') }}" class="mt-2 w-full rounded-xl border border-gray-700
                   bg-gray-950 px-4 py-3
                   text-white
                   outline-none
                   transition duration-200
                   focus:border-white
                   focus:ring-2 focus:ring-white/20" placeholder="https://example.com/cover.jpg">

                            <p class="mt-2 text-xs text-gray-500">
                                Kosongkan jika tidak ingin mengganti cover saat ini.
                            </p>

                            @error('cover_url')
                                <p class="mt-2 text-sm text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>


                        {{-- PREVIEW COVER --}}
                        <div id="cover-preview-container" class="mt-6 hidden">

                            <p class="text-sm font-semibold text-gray-200">
                                Preview Cover Baru
                            </p>

                            <div class="mt-3 overflow-hidden rounded-xl border border-gray-700
                    bg-gray-950 p-3">

                                <img id="cover-preview" src="" alt="Preview Cover Baru"
                                    class="mx-auto max-h-80 rounded-lg object-contain">

                            </div>

                        </div>


                        {{-- ERROR SUMBER COVER --}}
                        @error('cover_source')
                            <p class="mt-2 text-sm text-red-400">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- TOMBOL --}}
                    <div class="flex flex-col gap-3 pt-4 sm:flex-row">

                        <a href="{{ route('admin.data.buku.index') }}" class="flex-1 border-2 border-gray-700
                                   px-5 py-3
                                   text-center
                                   text-sm font-semibold
                                   uppercase tracking-wider
                                   text-gray-300
                                   transition duration-300
                                   hover:border-white hover:text-white">
                            Batal
                        </a>

                        <button type="submit" class="flex-1 border-2 border-white
                                   bg-white px-5 py-3
                                   text-sm font-semibold
                                   uppercase tracking-wider
                                   text-black
                                   transition duration-300
                                   hover:bg-transparent hover:text-white
                                   active:scale-[0.98]">
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </main>

</body>

</html>