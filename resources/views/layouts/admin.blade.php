<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel') - Desa Suruh</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tabler Icons (Untuk ikon-ikon keren) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
    
</head>

{{-- Layout Admin Panel yang berfunsi seperti dapur atau rumah nya bagian admin --}}

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- 1. SIDEBAR (Memanggil file partials yang sudah diperbaiki) --}}
        @include('layouts.partials.admin-sidebar')

        {{-- 2. KONTEN UTAMA (Kanan) --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
            
            {{-- Header/Navbar Atas --}}
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10">
                
                {{-- Judul Halaman (Dinamis) --}}
                <div class="flex items-center">
                    <button class="md:hidden text-gray-500 hover:text-gray-700 focus:outline-none mr-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <h2 class="text-xl font-bold text-gray-800 tracking-tight">
                        @yield('title', 'Dashboard')
                    </h2>
                </div>

                {{-- Profil Admin (Kanan Atas) --}}
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] uppercase font-bold text-green-600 bg-green-100 px-2 py-0.5 rounded-full inline-block">Administrator</p>
                    </div>
                    
                    {{-- Avatar Inisial --}}
                    <div class="h-10 w-10 rounded-full bg-yellow-400 text-green-900 flex items-center justify-center font-bold text-lg shadow-md border-2 border-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            {{-- Area Konten (Scrollable) --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                
                {{-- Di sini konten setiap halaman akan muncul --}}
                @yield('content')

            </main>
        </div>

    </div>

    {{-- Stack Scripts (Jika ada script khusus di halaman tertentu) --}}
    @stack('scripts')
</body>
</html>