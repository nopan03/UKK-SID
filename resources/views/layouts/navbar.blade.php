<nav x-data="{ mobileMenuOpen: false }" class="bg-gray-900 bg-opacity-30 backdrop-blur-sm fixed w-full z-20 top-0 start-0 border-b border-gray-200 border-opacity-20">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

        {{-- 1. Logo (Kiri) --}}
        <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img\SDA.png') }}" class="h-10" alt="Logo Desa">
        </a>

        {{-- 2. Bagian Kanan (Tombol Aksi & Hamburger) --}}
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            
            {{-- Tombol Login/Register/User Dropdown untuk Desktop --}}
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    {{-- Tampilan untuk Guest (belum login) --}}
                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        {{-- DIUBAH: text-sm -> text-base --}}
                        <button @click="open = !open" type="button" class="text-white hover:text-yellow-400 font-medium rounded-lg text-base transition-colors flex items-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display: none;">
                            <div class="py-1">
                                {{-- DIUBAH: text-sm -> text-base --}}
                                <a href="{{ route('login') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Log in</a>
                                @if (Route::has('register'))
                                    {{-- DIUBAH: text-sm -> text-base --}}
                                    <a href="{{ route('register') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Register</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    {{-- Tampilan untuk User yang Sudah Login --}}
                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        {{-- DIUBAH: text-sm -> text-base --}}
                        <button @click="open = !open" class="flex items-center space-x-2 text-white font-medium rounded-lg text-base text-center transition-colors hover:text-yellow-400">
                            <span>{{ Auth::user()->name }}</span> 
                            <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-10" style="display: none;">
                            <div class="py-1">
                                {{-- DIUBAH: text-sm -> text-base --}}
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    {{-- DIUBAH: text-sm -> text-base --}}
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-gray-100">
                                        Log Out
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Tombol Menu Hamburger untuk Mobile --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-200 rounded-lg md:hidden hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <span class="sr-only">Buka menu utama</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        {{-- 3. Daftar Menu Utama (Tengah) --}}
        <div :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" class="items-center justify-between w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-700 rounded-lg bg-gray-800/50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                
                {{-- 1. Beranda --}}
                <li>
                    {{-- DIUBAH: Ditambah text-lg --}}
                    <a href="{{ url('/') }}" class="block py-2 px-3 text-yellow-400 md:p-0 text-lg">Beranda</a>
                </li>

                {{-- 2. Dropdown: Profil Desa --}}
                <li x-data="{ open: false }" @click.outside="open = false" class="relative">
                    {{-- DIUBAH: Ditambah text-lg --}}
                    <button @click="open = !open" class="flex items-center justify-between w-full py-2 px-3 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:border-0 md:hover:text-yellow-400 md:p-0 md:w-auto text-lg">
                        Profil Desa
                        <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="py-1 md:absolute md:z-10 md:top-full md:left-0 md:mt-2 md:w-48 md:bg-white md:rounded-lg md:shadow-lg" style="display: none;">
                        {{-- DIUBAH: text-sm -> text-base --}}
                        <a href="#" class="block px-4 py-2 text-base text-gray-200 md:text-gray-700 hover:bg-gray-600 md:hover:bg-gray-100">Visi Misi</a>
                        <a href="#" class="block px-4 py-2 text-base text-gray-200 md:text-gray-700 hover:bg-gray-600 md:hover:bg-gray-100">Sejarah</a>
                        <a href="#" class="block px-4 py-2 text-base text-gray-200 md:text-gray-700 hover:bg-gray-600 md:hover:bg-gray-100">Struktur Organisasi</a>
                        <a href="#" class="block px-4 py-2 text-base text-gray-200 md:text-gray-700 hover:bg-gray-600 md:hover:bg-gray-100">Peta Desa</a>
                    </div>
                </li>
                
                {{-- 3. Dropdown: Informasi --}}
                <li x-data="{ open: false }" @click.outside="open = false" class="relative">
                    {{-- DIUBAH: Ditambah text-lg --}}
                    <button @click="open = !open" class="flex items-center justify-between w-full py-2 px-3 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:border-0 md:hover:text-yellow-400 md:p-0 md:w-auto text-lg">
                        Infgrafis
                        <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition class="py-1 md:absolute md:z-10 md:top-full md:left-0 md:mt-2 md:w-48 md:bg-white md:rounded-lg md:shadow-lg" style="display: none;">
                        {{-- DIUBAH: text-sm -> text-base --}}
                        <a href="#" class="block px-4 py-2 text-base text-gray-200 md:text-gray-700 hover:bg-gray-600 md:hover:bg-gray-100">Penduduk</a>
                        <a href="#" class="block px-4 py-2 text-base text-gray-200 md:text-gray-700 hover:bg-gray-600 md:hover:bg-gray-100">APBDes</a>
                    </div>
                </li>

                {{-- 4. Administrasi Surat --}}
                <li>
                    {{-- DIUBAH: Ditambah text-lg --}}
                    <a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:border-0 md:hover:text-yellow-400 md:p-0 text-lg">Administrasi Surat</a>
                </li>
                
                {{-- 5. Lapor Keluhan --}}
                <li>
                    {{-- DIUBAH: Ditambah text-lg --}}
                    <a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:border-0 md:hover:text-yellow-400 md:p-0 text-lg">Lapor Keluhan</a>
                </li>

                {{-- Tombol Aksi untuk Mobile (di dalam menu hamburger) --}}
                <li class="md:hidden mt-4 pt-4 border-t border-gray-600">
                    @guest
                        {{-- DIUBAH: Ditambah text-base --}}
                        <a href="{{ route('login') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700 text-base">Log in</a>
                        @if (Route::has('register'))
                            {{-- DIUBAH: Ditambah text-base --}}
                            <a href="{{ route('register') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700 text-base">Register</a>
                        @endif
                    @else
                        {{-- DIUBAH: Ditambah text-base --}}
                        <a href="{{ route('profile.edit') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700 text-base">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            {{-- DIUBAH: Ditambah text-base --}}
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-left py-2 px-3 text-white rounded hover:bg-gray-700 text-base">
                                Log Out
                            </a>
                        </form>
                    @endauth
                </li>
            </ul>
        </div>

    </div>
</nav>