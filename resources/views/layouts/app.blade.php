<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- Judul Tab Browser akan dinamis --}}
    <title>@yield('title', 'Desa Suruh')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
</head>
<body class="bg-white antialiased">

    {{-- Navbar akan otomatis ada di setiap halaman --}}
    @include('layouts.navbar')

    {{-- Konten Utama (akan diisi oleh halaman lain) --}}
    <main>
        @yield('content')
    </main>
    
    {{-- Footer akan otomatis ada di setiap halaman --}}
    {{-- (Saya asumsikan Anda punya file footer. Jika belum, baris ini bisa dihapus) --}}
    @include('landing.partials._footer') 

</body>
</html>