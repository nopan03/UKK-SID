<nav x-data="{ open: false }" class="bg-gray-900 bg-opacity-30 backdrop-blur-sm fixed w-full z-20 top-0 start-0 border-b border-gray-200 border-opacity-20">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">

        {{-- 1. Logo & Nama Desa (Sebelah Kiri) --}}
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/logo-desa.png') }}" class="h-10" alt="Logo Desa">
            <span class="self-center text-xl font-semibold whitespace-nowrap text-white">Desa Suruh</span>
        </a>

        {{-- 2. Bagian Kanan (Tombol Aksi & Hamburger) --}}
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
            
            {{-- Tombol untuk Desktop --}}
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-white hover:text-yellow-400 font-medium rounded-lg text-sm transition-colors">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-white bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2 text-center transition-colors">Register</a>
                    @endif
                @else
                    {{-- Dropdown untuk User yang Sudah Login --}}
                    <div x-data="{ open: false }" class="relative">
                        {{-- Tombol Pemicu Dropdown --}}
                        <button @click="open = !open" class="flex items-center space-x-2 text-white font-medium rounded-lg text-sm text-center transition-colors hover:text-yellow-400">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        {{-- Menu Dropdown --}}
                        <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Log Out
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            {{-- Tombol Menu Hamburger untuk Mobile --}}
            <button @click="open = !open" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-200 rounded-lg md:hidden hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-gray-400">
                <span class="sr-only">Buka menu utama</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        {{-- 3. Daftar Menu Utama (Tengah) --}}
        <div :class="{'block': open, 'hidden': !open}" class="items-center justify-between w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-700 rounded-lg bg-gray-800/50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">
                <li><a href="/" class="block py-2 px-3 text-yellow-400 md:p-0">Beranda</a></li>
                {{-- Anda bisa aktifkan lagi link-link ini jika halamannya sudah ada --}}
                {{-- <li><a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-yellow-400 md:p-0">Profil Desa</a></li> --}}
                {{-- <li><a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-yellow-400 md:p-0">Berita</a></li> --}}
                {{-- <li><a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700 md:hover:bg-transparent md:hover:text-yellow-400 md:p-0">Layanan</a></li> --}}

                {{-- Tombol Aksi untuk Mobile (di dalam menu hamburger) --}}
                <li class="md:hidden mt-4 pt-4 border-t border-gray-600">
                    @guest
                        <a href="{{ route('login') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700">Register</a>
                        @endif
                    @else
                        <a href="{{ route('profile.edit') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700">Profil Saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block w-full text-left py-2 px-3 text-white rounded hover:bg-gray-700">
                                Log Out
                            </a>
                        </form>
                    @endauth
                </li>
            </ul>
        </div>

    </div>
</nav>