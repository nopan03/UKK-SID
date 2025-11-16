<nav x-data="{ mobileMenuOpen: false }" class="bg-white/80 backdrop-blur-sm shadow-md py-4 sticky top-0 z-50 relative">

    <div class="absolute -bottom-28 left-0 z-30 w-40 h-auto">
        <img src="{{ asset('img/logo.png') }}" alt="Logo Desa Suruh" class="w-full h-full">
    </div>

    <div class="container mx-auto flex items-center justify-between relative pl-44">

        <div></div> {{-- Placeholder kosong untuk sisi kiri --}}

        {{-- 2. Bagian Kanan (Tombol Aksi & Hamburger) --}}
        <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        <button @click="open = !open" type="button"
                            class="text-gray-600 hover:text-yellow-500 font-medium rounded-lg text-base transition-colors flex items-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition
                            class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                            style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('login') }}"
                                    class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Register</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div x-data="{ open: false }" @click.outside="open = false" class="relative">
                        <button @click="open = !open"
                            class="flex items-center space-x-2 text-gray-600 font-medium rounded-lg text-base text-center transition-colors hover:text-yellow-500">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition
                            class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                            style="display: none;">
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Profil Saya</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="block w-full text-left px-4 py-2 text-base text-gray-700 hover:bg-gray-100">
                                        Log Out
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>

            <button @click="mobileMenuOpen = !mobileMenuOpen" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                <span class="sr-only">Buka menu utama</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>

        {{-- 3. Daftar Menu Utama (Tengah) --}}
        <div :class="{ 'block': mobileMenuOpen, 'hidden': !mobileMenuOpen }"
            class="items-center justify-between w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
            <ul
                class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-transparent">

                {{-- 
                  PERBAIKAN 1: Link "Beranda"
                  - {{ request()->is('/') ? 'text-yellow-500' : 'text-gray-900' }}
                    Artinya: JIKA URL-nya '/', beri warna kuning. JIKA TIDAK, beri warna abu-abu.
                  - Ditambahkan 'hover:text-yellow-500'
                --}}
                <li>
                    <a href="{{ url('/') }}"
                        class="block py-2 px-3 {{ request()->is('/') ? 'text-yellow-500' : 'text-gray-900' }} rounded md:bg-transparent md:hover:text-yellow-500 md:p-0 text-lg">Beranda</a>
                </li>

                {{-- 
                  PERBAIKAN 2: Dropdown "Profil Desa"
                  - {{ request()->is('sejarah-desa*') ? 'text-yellow-500' : 'text-gray-900' }}
                    Artinya: JIKA URL-nya 'sejarah-desa' (atau apapun yang diawali 'sejarah-desa'), 
                    beri warna kuning. JIKA TIDAK, beri warna abu-abu.
                --}}
                {{-- GANTI DENGAN BLOK LENGKAP INI --}}
                <li x-data="{ open: false }" @click.outside="open = false" class="relative">
                    {{-- 
      PERBAIKAN: 
      Sekarang mengecek 'sejarah-desa*' ATAU 'visi-misi*'
    --}}
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full py-2 px-3 {{ request()->is('sejarah-desa*', 'visi-misi*') ? 'text-yellow-500' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-yellow-500 md:p-0 md:w-auto text-lg">
                        Profil Desa
                        <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="py-1 md:absolute md:z-50 md:top-full md:left-0 md:mt-2 md:w-48 md:bg-white md:rounded-lg md:shadow-lg"
                        style="display: none;">
                        {{-- Link Sejarah (sudah benar) --}}
                        <a href="{{ route('sejarah') }}"
                            class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Sejarah</a>

                        {{-- PERBAIKAN: Link Visi Misi --}}
                        <a href="{{ route('visimisi') }}"
                            class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Visi Misi</a>

                        <a href="#" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Struktur
                            Organisasi</a>
                        <a href="#" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Peta
                            Desa</a>
                    </div>
                </li>

                {{-- PERBAIKAN 3: Dropdown "Infografis" --}}
                <li x-data="{ open: false }" @click.outside="open = false" class="relative">
                    <button @click="open = !open"
                        class="flex items-center justify-between w-full py-2 px-3 {{ request()->is('infografis*') ? 'text-yellow-500' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-yellow-500 md:p-0 md:w-auto text-lg">
                        Infografis
                        <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <div x-show="open" x-transition
                        class="py-1 md:absolute md:z-50 md:top-full md:left-0 md:mt-2 md:w-48 md:bg-white md:rounded-lg md:shadow-lg"
                        style="display: none;">
                        <a href="#"
                            class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">Penduduk</a>
                        <a href="#" class="block px-4 py-2 text-base text-gray-700 hover:bg-gray-100">APBDes</a>
                    </div>
                </li>

                {{-- PERBAIKAN 4: Link "Administrasi Surat" --}}
                <li>
                    <a href="#"
                        class="block py-2 px-3 {{ request()->is('administrasi-surat*') ? 'text-yellow-500' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-yellow-500 md:p-0 text-lg">Administrasi
                        Surat</a>
                </li>

                {{-- PERBAIKAN 5: Link "Lapor Keluhan" --}}
                <li>
                    <a href="#"
                        class="block py-2 px-3 {{ request()->is('lapor-keluhan*') ? 'text-yellow-500' : 'text-gray-900' }} rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-yellow-500 md:p-0 text-lg">Lapor
                        Keluhan</a>
                </li>

                {{-- Tombol Aksi untuk Mobile (tidak perlu diubah) --}}
                <li class="md:hidden mt-4 pt-4 border-t border-gray-200">
                    {{-- ... --}}
                </li>
            </ul>
        </div>

    </div>
</nav>
