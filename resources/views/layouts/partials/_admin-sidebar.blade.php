<aside class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-green-800 border-r dark:bg-green-900 dark:border-gray-700">

    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4">
        <img src="{{ asset('img/logo-desa.png') }}" class="h-10" alt="Logo Desa Suruh">
        <span class="self-center text-xl font-semibold whitespace-nowrap text-white">Desa Suruh</span>
    </a>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav>
            {{-- Sesuaikan Header Kategori dengan Screenshot --}}
            <p class="px-4 text-xs text-gray-400 uppercase font-bold mb-2">MASTER DATA</p>

            {{-- 1. Link Data Warga (LABEL DISAMAKAN, LINK DIPERBAIKI) --}}
            <a class="flex items-center px-4 py-2 mt-2 text-gray-200 rounded-md hover:bg-green-700 hover:text-white 
                {{ request()->routeIs('admin.warga.*') ? 'bg-yellow-500 text-white shadow-md' : '' }}"
                href="{{ route('admin.warga.index') }}"> {{-- <-- LINK INI YANG PENTING --}}
                
                {{-- Ikon Users --}}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                
                {{-- Teks disamakan dengan screenshot --}}
                <span class="mx-4 font-medium">Data Warga</span> 
            </a>

            {{-- 2. Link Berita Desa --}}
            <a class="flex items-center px-4 py-2 mt-2 text-gray-200 rounded-md hover:bg-green-700 hover:text-white 
                {{ request()->routeIs('admin.berita.*') ? 'bg-yellow-500 text-white shadow-md' : '' }}"
                href="{{ route('admin.berita.index') }}">
                
                {{-- Ikon Koran/Berita --}}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                
                <span class="mx-4 font-medium">Berita Desa</span>
            </a>

            {{-- 3. Link Keuangan Desa --}}
            <a class="flex items-center px-4 py-2 mt-2 text-gray-200 rounded-md hover:bg-green-700 hover:text-white 
                {{ request()->routeIs('admin.keuangan.*') ? 'bg-yellow-500 text-white shadow-md' : '' }}"
                href="{{ route('admin.keuangan.index') }}">
                
                {{-- Ikon Dompet --}}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>

            {{--4. Administrasi Surat--}}
            <a class="flex items-center px-4 py-2 mt-2 text-gray-200 rounded-md hover:bg-green-700 hover:text-white 
    {{ request()->routeIs('admin.surat.*') ? 'bg-yellow-500 text-white shadow-md' : '' }}"
    href="{{ route('admin.surat.index') }}">
    
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
    
    <span class="mx-4 font-medium">Verifikasi Surat</span>

</a>
                
                <span class="mx-4 font-medium">Keuangan Desa</span>
            </a>

        </nav>
    </div>
</aside>