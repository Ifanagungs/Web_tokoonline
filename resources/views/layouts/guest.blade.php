<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-emerald-50 via-white to-emerald-100 relative overflow-hidden">

        <div
            class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob">
        </div>
        <div
            class="absolute top-[20%] right-[-10%] w-72 h-72 bg-emerald-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000">
        </div>

        <div class="relative z-10 w-full sm:max-w-md flex flex-col items-center">
            {{-- <a href="/" class="group flex flex-col items-center mb-6">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="w-24 h-24 drop-shadow-md transition-transform duration-300 group-hover:scale-105">
            </a> --}}

            <div
                class="w-full px-8 py-10 bg-white/80 backdrop-blur-md shadow border border-white/50 overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>