<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased min-h-screen bg-slate-950 text-slate-100 selection:bg-emerald-500 selection:text-white">
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center overflow-hidden bg-slate-950 px-4 py-12">
            <!-- Ambient Light Blobs -->
            <div class="absolute -top-40 -left-40 w-[500px] h-[500px] rounded-full bg-emerald-500/10 blur-[120px] pointer-events-none"></div>
            <div class="absolute -bottom-40 -right-40 w-[500px] h-[500px] rounded-full bg-teal-500/10 blur-[120px] pointer-events-none"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[700px] h-[700px] rounded-full bg-indigo-500/5 blur-[150px] pointer-events-none"></div>

            <!-- Logo -->
            <div class="mb-6 z-10">
                <a href="/">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-600 text-white text-3xl font-black shadow-lg shadow-emerald-500/20 tracking-tighter hover:scale-105 transition-all duration-300">
                        UM
                    </div>
                </a>
            </div>

            <!-- Glassmorphic Card wrapping the content -->
            <div class="relative w-full {{ $attributes->get('card-width', 'sm:max-w-md') }} bg-slate-900/60 backdrop-blur-xl border border-slate-800/80 rounded-3xl shadow-2xl p-8 sm:p-10 z-10">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
