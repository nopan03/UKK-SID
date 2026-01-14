{{-- 
    ========================================================
    LOGIKA MENGHITUNG SURAT "SELESAI" / "DITOLAK" (NOTIFIKASI)
    ========================================================
    Kita hitung langsung di sini agar tidak perlu kirim dari controller setiap saat.
    Logic: Jika ada surat milik user yang statusnya 'selesai' atau 'ditolak',
    munculkan angka merah.
--}}
@php
    $jmlNotif = 0;
    if(Auth::check()) {
        $jmlNotif = \App\Models\Surat::where('user_id', Auth::id())
                        ->whereIn('status', [
                            'selesai', 'Selesai', 'SELESAI', 
                            'ditolak', 'Ditolak', 'DITOLAK'
                        ])
                        ->where(function($query) {
                            $query->where('is_read', 0)
                                  ->orWhereNull('is_read');
                        })
                        ->count();
    }
@endphp

<nav x-data="{ mobileMenuOpen: false }" class="bg-white/80 backdrop-blur-sm shadow-md py-3 md:py-4 sticky top-0 z-40 relative"> 
    
    {{-- 1. LOGO (DESKTOP & MOBILE) --}}
    <a href="{{ url('/') }}" class="hidden md:block absolute top-0 left-0 z-50 w-48 h-auto hover:opacity-95 transition">
        <img src="{{ asset('img/logo.png') }}" alt="Logo Desa Suruh" class="w-full h-full drop-shadow-md">
    </a>
    <a href="{{ url('/') }}" class="md:hidden absolute top-0 left-0 z-50 w-28 hover:opacity-95 transition">
        <img src="{{ asset('img/logo.png') }}" alt="Logo Desa Suruh" class="w-full h-full drop-shadow-md">
    </a>

    {{-- 2. CONTAINER MENU UTAMA --}}
    <div class="container mx-auto flex items-center justify-between px-4 pl-28 md:pl-[320px] relative">
        
        <div class="w-1"></div>

        {{-- 3. BAGIAN KANAN (LOGIN / USER DROPDOWN) --}}
        <div class="flex items-center md:order-2 space-x-3 rtl:space-x-reverse ml-auto">
            
            {{-- TAMPILAN DESKTOP --}}
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-yellow-500 font-medium flex items-center gap-1">
                        <i class="ti ti-user"></i> Masuk
                    </a>
                @else
                    {{-- 
                        ▼▼ USER DROPDOWN (DESKTOP) ▼▼ 
                    --}}
                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-1 text-gray-600 hover:text-yellow-500 font-medium focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            
                            {{-- Jika ada notifikasi, beri titik merah kecil di sebelah nama --}}
                            @if($jmlNotif > 0)
                                <span class="flex h-2 w-2 relative">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                                </span>
                            @endif

                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Isi Dropdown User --}}
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 z-50 border border-gray-100" 
                             style="display: none;">
                            
                            {{-- Link Profil --}}
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yellow-600">
                                Profil Saya
                            </a>

                            {{-- Link Riwayat Surat (DENGAN BADGE NOTIFIKASI) --}}
                            <a href="{{ route('warga.riwayat') }}" class="flex justify-between items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-yellow-600">
                                <span>Riwayat Surat</span>
                                @if($jmlNotif > 0)
                                    <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                        {{ $jmlNotif }}
                                    </span>
                                @endif
                            </a>

                            <div class="border-t border-gray-100 my-1"></div>

                            {{-- Tombol Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-semibold">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                    {{-- ▲▲ AKHIR DROPDOWN DESKTOP ▲▲ --}}
                @endauth
            </div>

            {{-- Hamburger Mobile --}}
            <button @click="mobileMenuOpen = true" type="button" class="md:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-md relative">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                {{-- Titik merah di menu burger jika ada notifikasi --}}
                @if(isset($jmlNotif) && $jmlNotif > 0)
                    <span class="absolute top-2 right-2 h-3 w-3 rounded-full bg-red-500 border-2 border-white"></span>
                @endif
            </button>
        </div>

        {{-- 4. MENU DESKTOP (Horizontal) --}}
        <div class="hidden md:flex items-center justify-between w-full md:w-auto md:order-1">
            <ul class="flex flex-row space-x-8 font-medium">
                <li><a href="{{ url('/') }}" class="block py-2 text-lg {{ request()->is('/') ? 'text-yellow-500' : 'text-gray-900 hover:text-yellow-500' }}">Beranda</a></li>
                
                {{-- Dropdown Profil Desa --}}
                <li x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button @click="open = !open" class="flex items-center py-2 text-lg {{ request()->is('sejarah-desa*', 'visi-misi*', 'struktur-organisasi*') ? 'text-yellow-500' : 'text-gray-900 hover:text-yellow-500' }}">
                        Profil Desa <svg class="w-2.5 h-2.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" class="absolute top-full left-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 z-50" style="display: none;">
                        <a href="{{ route('sejarah') }}" class="block px-4 py-2 hover:bg-yellow-50 hover:text-yellow-500">Sejarah</a>
                        <a href="{{ route('visimisi') }}" class="block px-4 py-2 hover:bg-yellow-50 hover:text-yellow-500">Visi Misi</a>
                        <a href="{{ route('struktur') }}" class="block px-4 py-2 hover:bg-yellow-50 hover:text-yellow-500">Struktur Organisasi</a>
                        <a href="{{ route('peta-desa') }}" class="block px-4 py-2 hover:bg-yellow-50 hover:text-yellow-500">Peta Desa</a>
                    </div>
                </li>

                {{-- Dropdown Infografis --}}
                <li x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button @click="open = !open" class="flex items-center py-2 text-lg {{ request()->is('infografis*') ? 'text-yellow-500' : 'text-gray-900 hover:text-yellow-500' }}">
                        Infografis <svg class="w-2.5 h-2.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="open" class="absolute top-full left-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 z-50" style="display: none;">
                        <a href="{{ route('infografis.penduduk') }}" class="block px-4 py-2 hover:bg-yellow-50 hover:text-yellow-500">Penduduk</a>
                        <a href="{{ route('infografis.apbdes') }}" class="block px-4 py-2 hover:bg-yellow-50 hover:text-yellow-500">APBDes</a>
                    </div>
                </li>

                <li><a href="{{ route('surat.index') }}" class="block py-2 text-lg {{ request()->is('administrasi*') ? 'text-yellow-500' : 'text-gray-900 hover:text-yellow-500' }}">Administrasi Surat</a></li>
                <li><a href="{{ route('keluhan.create') }}" class="block py-2 text-lg {{ request()->is('lapor*') ? 'text-yellow-500' : 'text-gray-900 hover:text-yellow-500' }}">Lapor Keluhan</a></li>
            </ul>
        </div>
    </div>


    {{-- 5. SIDEBAR MOBILE (PERBAIKAN DISINI) --}}
    <div x-cloak x-show="mobileMenuOpen" class="relative z-[100] md:hidden" role="dialog" aria-modal="true">
        <div x-show="mobileMenuOpen" class="fixed inset-0 bg-gray-900/80 transition-opacity" @click="mobileMenuOpen = false"></div>

        <div x-show="mobileMenuOpen" 
             class="fixed inset-y-0 left-0 z-[101] w-[85%] max-w-sm bg-white h-screen shadow-2xl flex flex-col">
            
            {{-- Header Mobile --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100 shrink-0 bg-white">
                <span class="text-xl font-bold text-gray-800">Desa Suruh</span>
                <button @click="mobileMenuOpen = false" class="-m-2.5 rounded-md p-2.5 text-gray-700 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            {{-- Menu Mobile --}}
            <div class="flex-1 overflow-y-auto px-6 py-6 bg-white">
                <div class="space-y-4">
                    <a href="{{ url('/') }}" class="block rounded-lg px-3 py-2 text-base font-semibold leading-7 {{ request()->is('/') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-900 hover:bg-gray-50' }}">
                        Beranda
                    </a>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                            Profil Desa <svg class="h-5 w-5 flex-none transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" class="mt-2 space-y-1 pl-4 border-l-2 border-gray-100">
                            <a href="{{ route('sejarah') }}" class="block rounded-lg py-2 pl-3 pr-3 text-sm font-semibold text-gray-600 hover:text-yellow-600">Sejarah</a>
                            <a href="{{ route('visimisi') }}" class="block rounded-lg py-2 pl-3 pr-3 text-sm font-semibold text-gray-600 hover:text-yellow-600">Visi Misi</a>
                            <a href="{{ route('struktur') }}" class="block rounded-lg py-2 pl-3 pr-3 text-sm font-semibold text-gray-600 hover:text-yellow-600">Struktur</a>
                            <a href="{{ route('peta-desa') }}" class="block rounded-lg py-2 pl-3 pr-3 text-sm font-semibold text-gray-600 hover:text-yellow-600">Peta Desa</a>
                        </div>
                    </div>

                    <div x-data="{ open: false }">
                        <button @click="open = !open" class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-base font-semibold leading-7 text-gray-900 hover:bg-gray-50">
                            Infografis <svg class="h-5 w-5 flex-none transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div x-show="open" class="mt-2 space-y-1 pl-4 border-l-2 border-gray-100">
                            <a href="{{ route('infografis.penduduk') }}" class="block rounded-lg py-2 pl-3 pr-3 text-sm font-semibold text-gray-600 hover:text-yellow-600">Penduduk</a>
                            <a href="{{ route('infografis.apbdes') }}" class="block rounded-lg py-2 pl-3 pr-3 text-sm font-semibold text-gray-600 hover:text-yellow-600">APBDes</a>
                        </div>
                    </div>

                    <a href="{{ route('surat.index') }}" class="block rounded-lg px-3 py-2 text-base font-semibold leading-7 {{ request()->is('administrasi*') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-900 hover:bg-gray-50' }}">
                        Administrasi Surat
                    </a>
                    <a href="{{ route('keluhan.create') }}" class="block rounded-lg px-3 py-2 text-base font-semibold leading-7 {{ request()->is('lapor*') ? 'bg-yellow-50 text-yellow-600' : 'text-gray-900 hover:bg-gray-50' }}">
                        Lapor Keluhan
                    </a>
                </div>
            </div>

            {{-- Footer Mobile (Bagian Akun) --}}
            <div class="shrink-0 border-t border-gray-200 bg-gray-50 px-6 py-6">
                @guest
                    <a href="{{ route('login') }}" class="flex w-full items-center justify-center rounded-md bg-green-700 px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-800">
                        Log in
                    </a>
                @else
                    <div class="space-y-3">
                        <div class="flex items-center justify-between px-2">
                            <div class="text-sm font-medium text-gray-500">Halo, {{ Auth::user()->name }}</div>
                            {{-- Notif Merah di Mobile --}}
                            @if($jmlNotif > 0)
                                <span class="bg-red-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    {{ $jmlNotif }} Surat Selesai
                                </span>
                            @endif
                        </div>

                        <a href="{{ route('profile.edit') }}" class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2.5 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50">
                            Profil Saya
                        </a>
                        
                        {{-- Link Riwayat Surat Mobile --}}
                        <a href="{{ route('warga.riwayat') }}" class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2.5 text-center text-sm font-semibold text-gray-700 hover:bg-gray-50 {{ $jmlNotif > 0 ? 'border-red-300 text-red-600 bg-red-50' : '' }}">
                            Riwayat Surat
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full rounded-md bg-red-600 px-3 py-2.5 text-center text-sm font-semibold text-white hover:bg-red-700">
                                Log Out
                            </button>
                        </form>
                    </div>
                @endauth
                <p class="mt-4 text-center text-xs text-gray-400">© 2025 Desa Suruh</p>
            </div>

        </div>
    </div>

</nav>