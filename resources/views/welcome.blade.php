<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Desa Suruh - Membangun Bersama</title>

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('img/SDA1.png') }}" type="image/png">

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />

    {{-- Tailwind / Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi Custom */
        @keyframes colorPulse {
            0% { background-color: #f9fafb; }
            50% { background-color: #f0fdf4; }
            100% { background-color: #f9fafb; }
        }
        .animate-bg-pulse { animation: colorPulse 6s infinite ease-in-out; }
        
        @keyframes subtleZoom {
            0% { transform: scale(1.0); }
            100% { transform: scale(1.1); }
        }
        .animate-subtle-zoom { animation: subtleZoom 20s infinite alternate ease-in-out; }
    </style>
</head>
<body class="antialiased font-sans text-gray-900 bg-white">

    {{-- 1. NAVBAR --}}
    @include('layouts.navbar')

    {{-- 2. HERO SECTION (Gambar Sawah & Tombol Pintar) --}}
    @include('landing.partials._hero')

    {{-- 3. SAMBUTAN KADES --}}
    @include('landing.partials._sambutan')

    {{-- 4. BERITA TERBARU --}}
    @include('landing.partials._news')

    {{-- 5. FOOTER --}}
    @include('landing.partials._footer')

    {{-- SCRIPT ANIMASI --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true, duration: 800, offset: 100 });
    </script>
</body>
</html>