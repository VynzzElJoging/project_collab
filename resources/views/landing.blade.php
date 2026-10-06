<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Landing Page</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-white text-gray-950 antialiased flex items-center justify-center">

    <div class="w-full max-w-2xl px-6">

        <div class="rounded-2xl border border-gray-200 bg-white p-10 text-center shadow-xl shadow-gray-200/50">

            <h1 class="mb-10 text-5xl font-smooch font-bold tracking-wide text-gray-950">
                WELCOME  TO MY WEBSITE
            </h1>

            <div class="flex items-center justify-center gap-4">

                <a href="{{ route('login') }}" class="rounded-lg border border-gray-950 bg-gray-950 px-6 py-2.5 font-semibold text-white
                           transition-all duration-300
                           hover:bg-gray-800
                           hover:shadow-lg hover:shadow-gray-400/30
                           active:scale-95">
                    LOGIN
                </a>

                <a href="{{ route('register') }}" class="rounded-lg border border-gray-300 bg-white px-6 py-2.5 font-semibold text-gray-950
                           transition-all duration-300
                           hover:bg-gray-100
                           hover:border-gray-950
                           hover:shadow-lg hover:shadow-gray-300/30
                           active:scale-95">
                    REGISTER
                </a>

            </div>

        </div>

    </div>

</body>

</html>