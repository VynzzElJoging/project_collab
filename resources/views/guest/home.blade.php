<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Guest Home</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-950 text-gray-50 antialiased flex items-center justify-center px-4">

    {{-- Card Guest --}}
    <div class="rounded-2xl bg-gradient-to-r from-green-500 to-emerald-600 p-[1px] shadow-2xl shadow-green-500/10">

        <div class="bg-slate-950 p-10 text-center">

            {{-- Judul --}}
            <h1 class="text-5xl font-bold font-smooch
                       bg-gradient-to-r from-green-400 via-emerald-500 to-green-700
                       bg-clip-text text-transparent">
                Home Guest
            </h1>


            {{-- Welcome --}}
            <h2 class="mt-6 text-2xl font-semibold text-white">

                Selamat datang,

                <span class="text-green-400">
                    {{ Auth::user()->username }}
                </span>

            </h2>


            {{-- Deskripsi --}}
            <p class="mt-3 text-slate-400">
                Anda login sebagai Guest.
            </p>


            {{-- Tombol Logout --}}
            <form action="{{ route('logout') }}" method="POST" class="mt-8">

                @csrf

                <button type="submit" class="rounded-lg bg-transparent
                           px-6 py-3
                           font-semibold text-white
                           shadow-lg shadow-green-500/20
                           transition-all duration-300 delay-75
                           hover:-translate-y-0.5
                           hover:bg-gradient-to-r
                           hover:from-green-500 hover:to-emerald-600
                           hover:shadow-xl hover:shadow-green-500/30
                           active:translate-y-0
                           active:scale-95">
                    LOGOUT
                </button>

            </form>

        </div>

    </div>

</body>

</html>
