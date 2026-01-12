<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Judul tab browser:
    --}}
    <title>{{ $title ?? trim($__env->yieldContent('title', 'Desa Suruh')) }}</title>

    {{-- Asset dari Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Icon library --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
</head>

{{--  --}}

<body class="bg-white antialiased">

    {{-- Navbar global --}}
    @include('layouts.navbar')

    {{-- Konten utama --}}
    <main>
        {{-- Untuk halaman yang pakai <x-app-layout> (Breeze) --}}
        {{ $slot ?? '' }}

        {{-- Untuk halaman yang pakai @extends('layouts.app') --}}
        @yield('content')
    </main>

    {{-- Footer global --}}
    @include('landing.partials._footer')

    @stack('scripts')
</body>
</html>
