<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Peminjaman</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-black">

    <main class="px-4 py-6 sm:px-6 lg:px-9">

        <section class="rounded-2xl bg-gray-300 px-5 py-7 sm:px-7 sm:py-8 lg:px-10 lg:py-10">

            <p class="text-sm font-semibold tracking-[0.25em] text-gray-500">
                ADMIN PANEL
            </p>

            <h1 class="mt-2 text-3xl font-semibold tracking-[0.08em] sm:text-4xl">
                TAMBAH PEMINJAMAN
            </h1>

            <p class="mt-3 max-w-2xl text-sm leading-relaxed text-gray-600">
                Buat transaksi peminjaman buku untuk anggota perpustakaan.
            </p>

            @if ($errors->any())
                <div class="mt-6 rounded-xl border-2 border-red-500 bg-red-50 p-5 text-red-700">
                    <p class="font-semibold">
                        Terdapat kesalahan:
                    </p>

                    <ul class="mt-2 list-disc pl-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.data.peminjaman.store') }}" method="POST" class="mt-8">
                @csrf

                {{-- ANGGOTA --}}
                <div>
                    <label class="text-sm font-semibold">
                        Anggota
                    </label>

                    <select name="anggota_id" required
                        class="mt-2 w-full border-2 border-black bg-white px-4 py-3 outline-none">
                        <option value="">
                            Pilih Anggota
                        </option>

                        @foreach ($anggotas as $anggota)
                            <option value="{{ $anggota->id }}" {{ old('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                {{ $anggota->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- BUKU --}}
                <div class="mt-8">

                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-sm font-semibold">
                                Pilih Buku
                            </label>

                            <p class="mt-1 text-xs text-gray-500">
                                Maksimal 3 buku dalam satu transaksi.
                            </p>
                        </div>

                        <span id="jumlah-buku" class="text-sm font-bold">
                            0 / 3
                        </span>
                    </div>

                    <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach ($books as $book)

                            <label
                                class="book-option flex cursor-pointer items-center gap-3 rounded-xl border-2 border-black bg-white p-4 transition hover:bg-gray-100">

                                <input type="checkbox" name="books[]" value="{{ $book->id }}" class="book-checkbox h-5 w-5"
                                    {{ in_array($book->id, old('books', [])) ? 'checked' : '' }}>

                                <div>
                                    <p class="font-semibold">
                                        {{ $book->judul }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ $book->penulis }}
                                    </p>

                                    <p class="mt-1 text-xs font-semibold">
                                        Stok: {{ $book->stok }}
                                    </p>
                                </div>

                            </label>

                        @endforeach

                    </div>

                </div>

                {{-- INFO --}}
                <div class="mt-8 rounded-xl bg-white p-5">

                    <p class="font-semibold">
                        Ketentuan Peminjaman
                    </p>

                    <ul class="mt-3 space-y-1 text-sm text-gray-600">
                        <li>• Maksimal 3 buku per transaksi.</li>
                        <li>• Lama peminjaman 7 hari.</li>
                        <li>• Denda Rp2.000 per buku per hari keterlambatan.</li>
                    </ul>

                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:justify-end">

                    <a href="{{ route('admin.data.peminjaman.index') }}"
                        class="border-2 border-black bg-white px-6 py-3 text-center text-sm font-semibold transition hover:bg-black hover:text-white">
                        BATAL
                    </a>

                    <button type="submit"
                        class="border-2 border-black bg-black px-6 py-3 text-sm font-semibold text-white transition hover:bg-white hover:text-black">
                        SIMPAN PEMINJAMAN
                    </button>

                </div>

            </form>

        </section>

    </main>

    <script>
        const checkboxes = document.querySelectorAll('.book-checkbox');
        const jumlahBuku = document.getElementById('jumlah-buku');

        function updateJumlahBuku() {
            const jumlahDipilih = document.querySelectorAll(
                '.book-checkbox:checked'
            ).length;

            jumlahBuku.textContent = `${jumlahDipilih} / 3`;

            checkboxes.forEach((checkbox) => {

                if (!checkbox.checked) {
                    checkbox.disabled =
                        jumlahDipilih >= 3;
                } else {
                    checkbox.disabled = false;
                }

            });
        }

        checkboxes.forEach((checkbox) => {
            checkbox.addEventListener(
                'change',
                updateJumlahBuku
            );
        });

        updateJumlahBuku();
    </script>

</body>

</html>