<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Desa Suruh') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    {{-- 
       PERBAIKAN:
       1. Hapus 'h-screen' -> Ganti 'min-h-screen' (Biar bisa discroll kalau layar pendek).
       2. Hapus 'overflow-hidden' (Izinkan scroll).
       3. Tambah 'py-12' (Jarak aman atas-bawah).
    --}}
    <body class="font-sans text-gray-900 antialiased min-h-screen bg-green-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        {{-- WRAPPER UTAMA --}}
        <div class="w-full max-w-lg flex flex-col items-center relative z-10">

            {{-- HEADER (LOGO & JUDUL) --}}
            <div class="text-center mb-6">
                <a href="/" class="inline-block transition transform hover:scale-105 duration-300">
                    {{-- Logo --}}
                    <img src="{{ asset('img/SDA1.png') }}" alt="Logo Desa Suruh" class="w-20 md:w-24 h-auto drop-shadow-lg mx-auto">
                </a>
                
                {{-- Judul --}}
                <h2 class="mt-4 text-xl md:text-2xl font-extrabold text-gray-800 tracking-tight leading-tight">
                    Sistem Informasi <br class="md:hidden"> Manajemen Desa Suruh
                </h2>
                <p class="mt-2 text-xs md:text-sm text-gray-600 leading-snug">
                    Gerbang layanan digital terpadu administrasi desa.
                </p>
            </div>

            {{-- KOTAK FORMULIR --}}
            <div class="w-full bg-white shadow-2xl rounded-2xl border-t-4 border-primary-yellow px-6 py-8">
                {{ $slot }}
            </div>

            {{-- Footer --}}
            <div class="mt-6 text-center text-[10px] md:text-xs text-gray-400">
                &copy; {{ date('Y') }} Pemerintah Desa Suruh.
            </div>

        </div>

        {{-- Background Decoration --}}
        <div class="absolute bottom-0 w-full h-1/2 bg-gradient-to-t from-green-100 to-transparent opacity-50 z-0 pointer-events-none fixed"></div>

    </body>
</html>