<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') - Desa Suruh</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" />
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        {{-- SIDEBAR (Warna Hijau Tua) --}}
        <aside class="w-64 bg-green-900 text-white flex flex-col flex-shrink-0 transition-all duration-300 shadow-xl">
            
            {{-- Header Sidebar --}}
            <div class="h-16 flex items-center justify-center border-b border-green-800 bg-green-900 shadow-md z-10">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('img/SDA1.png') }}" alt="Logo" class="h-8 w-auto">
                    <span class="text-lg font-bold tracking-wider text-white">DESA SURUH</span>
                </div>
            </div>

            {{-- Menu Navigasi --}}
            <div class="flex-1 overflow-y-auto py-4">
                <nav class="px-3 space-y-1">
                    
                    {{-- Dashboard --}}
                    <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-4 py-3 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.dashboard') ? 'bg-yellow-500 text-green-900 font-bold' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                        <i class="ti ti-layout-dashboard text-xl mr-3"></i> Dashboard
                    </a>
                    
                    <div class="my-4 border-t border-green-800"></div>
                    <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider mb-2">Master Data</p>

                    {{-- Data Warga --}}
                    <a href="{{ route('admin.warga.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.warga*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                        <i class="ti ti-users text-xl mr-3 text-blue-300"></i> Data Warga
                    </a>

                    {{-- Berita --}}
                    <a href="{{ route('admin.berita.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.berita*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                        <i class="ti ti-news text-xl mr-3 text-green-300"></i> Berita Desa
                    </a>
                    
                    {{-- Keuangan --}}
                    <a href="{{ route('admin.keuangan.index') }}" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.keuangan*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                        <i class="ti ti-wallet text-xl mr-3 text-purple-300"></i> Keuangan Desa
                    </a>

                    <div class="my-4 border-t border-green-800"></div>
                    <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider mb-2">Layanan</p>

                    {{-- 
                       ▼▼ PERBAIKAN UTAMA: DROPDOWN PEMISAH JENIS SURAT ▼▼
                       Kita gunakan Alpine.js (x-data) untuk membuat dropdown buka-tutup.
                    --}}
                    <div x-data="{ open: {{ request()->routeIs('admin.surat*') ? 'true' : 'false' }} }" class="space-y-1">
                        
                        {{-- Tombol Utama Dropdown --}}
                        <button @click="open = !open" type="button" 
                            class="w-full group flex items-center justify-between px-4 py-2 text-sm font-medium rounded-lg transition {{ request()->routeIs('admin.surat*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                            <div class="flex items-center">
                                <i class="ti ti-mail-opened text-xl mr-3 text-yellow-400"></i>
                                <span>Permohonan Surat</span>
                            </div>
                            {{-- Panah Kecil --}}
                            <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Isi Dropdown (Sub-menu) --}}
                        <div x-show="open" x-transition class="pl-11 space-y-1" style="display: none;">
                            
                            {{-- Link: Semua Surat --}}
                            <a href="{{ route('admin.surat.index') }}" 
                               class="block px-4 py-2 text-sm rounded-md hover:bg-green-700 hover:text-white {{ request()->fullUrlIs(route('admin.surat.index')) ? 'text-white font-bold bg-green-800' : 'text-green-200' }}">
                                Semua Surat
                            </a>
                            
                            <div class="border-t border-green-800 my-1"></div>

                            {{-- Link: Jenis-Jenis Surat --}}
                            {{-- Nanti di Controller kita tambahkan filter: $request->jenis --}}
                            <a href="{{ route('admin.surat.index', ['jenis' => 'sktm']) }}" class="block px-4 py-2 text-sm text-green-200 hover:text-white hover:bg-green-700 rounded-md">SKTM</a>
                            <a href="{{ route('admin.surat.index', ['jenis' => 'sku']) }}" class="block px-4 py-2 text-sm text-green-200 hover:text-white hover:bg-green-700 rounded-md">SKU (Usaha)</a>
                            <a href="{{ route('admin.surat.index', ['jenis' => 'domisili']) }}" class="block px-4 py-2 text-sm text-green-200 hover:text-white hover:bg-green-700 rounded-md">Domisili</a>
                            <a href="{{ route('admin.surat.index', ['jenis' => 'skck']) }}" class="block px-4 py-2 text-sm text-green-200 hover:text-white hover:bg-green-700 rounded-md">Pengantar SKCK</a>
                            <a href="{{ route('admin.surat.index', ['jenis' => 'kelahiran']) }}" class="block px-4 py-2 text-sm text-green-200 hover:text-white hover:bg-green-700 rounded-md">Kelahiran</a>
                            <a href="{{ route('admin.surat.index', ['jenis' => 'kematian']) }}" class="block px-4 py-2 text-sm text-green-200 hover:text-white hover:bg-green-700 rounded-md">Kematian</a>
                            
                        </div>
                    </div>
                    {{-- ▲▲ AKHIR DROPDOWN ▲▲ --}}

                    {{-- Keluhan --}}
                    <a href="#" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition text-green-100 hover:bg-green-800 hover:text-white">
                        <i class="ti ti-message-exclamation text-xl mr-3 text-red-400"></i>
                        Keluhan Warga
                    </a>

                    <div class="my-4 border-t border-green-800"></div>
                    <p class="px-4 text-xs font-semibold text-green-300 uppercase tracking-wider mb-2">Monitoring</p>

                    {{-- Log Aktivitas --}}
                    <a href="#" class="group flex items-center px-4 py-2 text-sm font-medium rounded-lg transition text-green-100 hover:bg-green-800 hover:text-white">
                        <i class="ti ti-activity-heartbeat text-xl mr-3 text-blue-300"></i>
                        Log Aktivitas
                    </a>
                </nav>
            </div>

            {{-- Footer Sidebar --}}
            <div class="p-4 border-t border-green-800 bg-green-900">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-red-300 hover:bg-red-900/50 hover:text-white rounded-lg transition">
                        <i class="ti ti-logout text-xl mr-3"></i> Keluar
                    </button>
                </form>
            </div>
        </aside>

        {{-- KONTEN UTAMA (Kanan) --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-100">
            
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-8 z-0">
                <h2 class="text-xl font-bold text-gray-800">
                    @yield('header', 'Dashboard')
                </h2>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden md:block">
                        <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-green-600 font-bold">Administrator</p>
                    </div>
                    <div class="h-10 w-10 rounded-full bg-yellow-400 text-green-900 flex items-center justify-center font-bold text-lg shadow">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
                @yield('content')
            </main>
        </div>

    </div>

    @stack('scripts')
</body>
</html>