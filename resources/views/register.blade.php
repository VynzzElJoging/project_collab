<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Register</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-gray-950 antialiased flex items-center justify-center px-4">

    {{-- Card Register --}}
    <div class="w-full max-w-md">

        {{-- Judul --}}
        <div class="text-center mb-8">

            <h1 class="text-5xl font-bold font-smooch text-gray-950">
                Create Account
            </h1>

            <p class="text-gray-500 mt-2">
                Buat akun baru untuk melanjutkan
            </p>

        </div>


        {{-- Card --}}
        <div class="rounded-2xl border border-gray-200 bg-white shadow-xl shadow-gray-200/50 p-8">

            {{-- Form Register --}}
            <form action="{{ url('/register') }}" method="POST" class="space-y-5">

                @csrf
                {{-- Username --}}
                <div>

                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        Username
                    </label>

                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        placeholder="Buat username" class="w-full px-4 py-3
                               bg-white
                               border border-gray-300
                               rounded-xl
                               text-gray-950
                               placeholder-gray-400
                               outline-none
                               focus:ring-2 focus:ring-gray-950
                               focus:border-gray-950
                               transition">

                    @error('username')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Password --}}
                <div>

                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>

                    <input type="password" id="password" name="password" placeholder="Minimal 8 karakter" class="w-full px-4 py-3
                               bg-white
                               border border-gray-300
                               rounded-xl
                               text-gray-950
                               placeholder-gray-400
                               outline-none
                               focus:ring-2 focus:ring-gray-950
                               focus:border-gray-950
                               transition">

                    @error('password')
                        <p class="text-red-600 text-sm mt-2">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Konfirmasi Password --}}
                <div>

                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password
                    </label>

                    <input type="password" id="password_confirmation" name="password_confirmation"
                        placeholder="Ulangi password" class="w-full px-4 py-3
                               bg-white
                               border border-gray-300
                               rounded-xl
                               text-gray-950
                               placeholder-gray-400
                               outline-none
                               focus:ring-2 focus:ring-gray-950
                               focus:border-gray-950
                               transition">

                </div>


                {{-- Tombol Register --}}
                <button type="submit" class="w-full
                           bg-gray-950
                           text-white
                           font-semibold
                           py-3
                           rounded-xl
                           border border-gray-950
                           transition-all
                           duration-300
                           hover:bg-gray-800
                           hover:shadow-lg
                           hover:shadow-gray-400/30
                           active:scale-[0.98]">
                    Create Account
                </button>

            </form>


            {{-- Link Login --}}
            <div class="text-center mt-6">

                <p class="text-gray-500 text-sm">

                    Sudah punya akun?

                    <a href="{{ route('login') }}"
                        class="text-gray-950 hover:text-gray-600 font-semibold transition duration-200">
                        Login
                    </a>

                </p>

            </div>

        </div>

    </div>

</body>

</html>