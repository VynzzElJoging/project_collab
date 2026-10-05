<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Guest Home</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-950 text-gray-50 antialiased">

    {{-- ================= NAVBAR ================= --}}
    <nav class="w-full border-b border-green-500/20 bg-slate-950">

        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

          
       {{-- PROFIL KIRI --}}
<a href="{{ route('guest.profile') }}"
   class="flex items-center gap-3">

    {{-- Avatar --}}
    <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center font-bold overflow-hidden">

        @if (optional(Auth::user()->anggota)->foto)

            <img
                src="{{ asset('storage/' . optional(Auth::user()->anggota)->foto) }}"
                alt="Foto {{ optional(Auth::user()->anggota)->nama }}"
                class="w-full h-full object-cover"
            >

        @else

            {{ strtoupper(substr(optional(Auth::user()->anggota)->nama ?? Auth::user()->username, 0, 1)) }}

        @endif

    </div>

    {{-- Nama --}}
    <div>
        <p class="font-semibold text-white">
            {{ optional(Auth::user()->anggota)->nama ?? Auth::user()->username }}
        </p>

        <p class="text-sm text-slate-400">
            anggota
        </p>
    </div>

</a>


            {{-- MENU --}}
            <div class="flex items-center justify-center">

                <a href="#"
                   class="mr-6 font-medium text-slate-300
                          transition duration-200
                          hover:text-green-400">
                    Home
                </a>
                
            </div>


            {{-- LOGOUT --}}
            <div>

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button type="submit"
                            class="rounded-lg px-4 py-2
                                   font-semibold text-white
                                   transition duration-200
                                   hover:bg-green-500/20
                                   hover:text-green-400">

                        Logout

                    </button>

                </form>

            </div>

        </div>

    </nav>


  {{-- ================= HOME ================= --}}
<main class="px-6 py-10">

    <div class="mx-auto max-w-7xl">

        {{-- Judul --}}
        <div class="mb-8">

            <h1 class="text-3xl font-bold text-green-400">
                Koleksi Buku
            </h1>

            <p class="mt-2 text-slate-400">
                Pilih buku yang ingin kamu lihat.
            </p>

        </div>


        {{-- DAFTAR BUKU --}}
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">

            @forelse ($books as $book)

                <div class="overflow-hidden rounded-2xl border border-gray-800
                            bg-slate-900 shadow-lg transition duration-300
                            hover:-translate-y-1 hover:border-green-500">

                    {{-- COVER --}}
                    <div class="h-72 bg-gray-800">

                        @if ($book->cover)

                            <img
                                src="{{ asset('storage/' . $book->cover) }}"
                                alt="Cover {{ $book->judul }}"
                                class="h-full w-full object-cover"
                            >

                        @else

                            <div class="flex h-full items-center justify-center text-6xl">
                                📖
                            </div>

                        @endif

                    </div>


                    {{-- INFORMASI BUKU --}}
                    <div class="p-5">

                        <h2 class="line-clamp-2 text-lg font-bold text-white">
                            {{ $book->judul }}
                        </h2>

                        <p class="mt-2 text-sm text-gray-400">
                            {{ $book->penulis }}
                        </p>

                        <div class="mt-4 flex items-center justify-between">

                            <span class="rounded-full bg-green-500/10
                                         px-3 py-1 text-xs font-semibold
                                         text-green-400">
                                {{ $book->kategori }}
                            </span>

                            <span class="text-sm text-gray-400">
                                Stok: {{ $book->stok }}
                            </span>

                        </div>

                    </div>

                </div>

            @empty

                <div class="col-span-full rounded-2xl border border-gray-800
                            bg-slate-900 p-10 text-center">

                    <div class="text-5xl">
                        📚
                    </div>

                    <p class="mt-4 text-gray-400">
                        Belum ada buku yang tersedia.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</main>
</body>

</html>