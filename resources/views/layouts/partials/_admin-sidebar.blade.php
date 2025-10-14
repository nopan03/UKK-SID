<aside class="flex flex-col w-64 h-screen px-4 py-8 overflow-y-auto bg-green-800 border-r dark:bg-green-900 dark:border-gray-700">
    
    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4">
        <img src="{{ asset('img/logo-desa.png') }}" class="h-10" alt="Logo Desa Suruh">
        <span class="self-center text-xl font-semibold whitespace-nowrap text-white">Desa Suruh</span>
    </a>

    <div class="flex flex-col justify-between flex-1 mt-6">
        <nav>
            <p class="px-4 text-xs text-gray-400 uppercase">Menu Admin</p>
            
            {{-- Link untuk Manajemen Warga --}}
            <a class="flex items-center px-4 py-2 mt-5 text-gray-200 rounded-md hover:bg-green-700 hover:text-white 
                {{ request()->routeIs('admin.dashboard') || request()->routeIs('admin.warga.*') ? 'bg-green-700 text-white' : '' }}" 
               href="{{ route('admin.dashboard') }}">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="mx-4 font-medium">Manajemen Warga</span>
            </a>

            {{-- Link untuk Manajemen Berita (INI YANG DIPERBAIKI) --}}
            <a class="flex items-center px-4 py-2 mt-5 text-gray-200 rounded-md hover:bg-green-700 hover:text-white 
                {{ request()->routeIs('admin.berita.*') ? 'bg-green-700 text-white' : '' }}" 
               href="{{ route('admin.berita.index') }}">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 22H5C3.89543 22 3 21.1046 3 20V6C3 4.89543 3.89543 4 5 4H19C20.1046 4 21 4.89543 21 6V20C21 21.1046 20.1046 22 19 22Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M16.5 4V2M7.5 4V2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M3 10H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="mx-4 font-medium">Manajemen Berita</span>
            </a>

        </nav>
    </div>
</aside>