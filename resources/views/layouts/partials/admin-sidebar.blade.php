<aside class="flex flex-col w-64 h-screen bg-green-900 border-r border-green-800 text-white flex-shrink-0 transition-all duration-300 z-30 hidden lg:flex">

    {{-- 1. LOGO & HEADER --}}
    <div class="flex items-center justify-center h-16 px-4 bg-green-900 border-b border-green-800 shadow-sm">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
            <img src="{{ asset('img/SDA1.png') }}" class="h-8 w-auto" alt="Logo">
            <span class="font-bold text-lg tracking-wide">DESA SURUH</span>
        </a>
    </div>

    {{-- 2. MENU NAVIGASI (Scrollable) --}}
    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 custom-scrollbar">
        
        <p class="px-4 text-xs font-bold text-green-300 uppercase tracking-wider mb-2 mt-2">Menu Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-green-700 text-white shadow-sm' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
            <i class="ti ti-layout-dashboard text-xl mr-3"></i>
            <span>Dashboard</span>
        </a>

        <div class="my-4 border-t border-green-800/50"></div>
        <p class="px-4 text-xs font-bold text-green-300 uppercase tracking-wider mb-2">Master Data</p>

        {{-- Data Warga --}}
        <a href="{{ route('admin.warga.index') }}" 
           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.warga.*') ? 'bg-green-700 text-white shadow-sm' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
            <i class="ti ti-users text-xl mr-3"></i>
            <span>Data Warga</span>
        </a>

        {{-- 🔥 MENU VERIFIKASI PENDATANG (PINDAH KE SINI) 🔥 --}}
        @php
            // Hitung notifikasi pendatang langsung di sini
            $notifPendatang = \App\Models\LaporDiri::where('status', 'menunggu')->count();
        @endphp
        <a href="{{ route('admin.pendatang.index') }}" 
           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.pendatang.*') ? 'bg-green-700 text-white shadow-sm' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
            <i class="ti ti-user-check text-xl mr-3"></i>
            <span class="flex-1">Verifikasi Pendatang</span>
            
            {{-- Badge Notifikasi Pendatang --}}
            @if($notifPendatang > 0)
                <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                    {{ $notifPendatang }}
                </span>
            @endif
        </a>

        {{-- Berita --}}
        <a href="{{ route('admin.berita.index') }}" 
           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.berita.*') ? 'bg-green-700 text-white shadow-sm' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
            <i class="ti ti-news text-xl mr-3"></i>
            <span>Berita Desa</span>
        </a>

        {{-- Keuangan --}}
        <a href="{{ route('admin.keuangan.index') }}" 
           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.keuangan.*') ? 'bg-green-700 text-white shadow-sm' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
            <i class="ti ti-wallet text-xl mr-3"></i>
            <span>Keuangan</span>
        </a>

        <div class="my-4 border-t border-green-800/50"></div>
        <p class="px-4 text-xs font-bold text-green-300 uppercase tracking-wider mb-2">Layanan</p>

        {{-- DROPDOWN PERMOHONAN SURAT --}}
        <div x-data="{ open: {{ request()->routeIs('admin.surat.*') ? 'true' : 'false' }} }">
            
            {{-- TOMBOL INDUK --}}
            <button @click="open = !open" type="button" 
                class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.surat.*') ? 'bg-green-800 text-white' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
                
                <div class="flex items-center w-full">
                    <i class="ti ti-mail-opened text-xl mr-3"></i>
                    <span>Permohonan Surat</span>
                    
                    {{-- Badge Total Surat --}}
                    @if(isset($totalSurat) && $totalSurat > 0)
                        <span x-show="!open" 
                              class="ml-auto bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                            {{ $totalSurat }}
                        </span>
                    @endif
                </div>
                
                <svg x-show="open || {{ $totalSurat ?? 0 }} == 0" class="w-4 h-4 transition-transform duration-200 ml-auto" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </button>

            {{-- SUB-MENU (Anak Surat) --}}
            <div x-show="open" x-collapse class="space-y-1 mt-1 pl-11 pr-2">
                <a href="{{ route('admin.surat.index') }}" 
                   class="block px-3 py-2 rounded-md text-sm transition-colors duration-200 {{ !request()->has('jenis') && request()->routeIs('admin.surat.index') ? 'text-white bg-green-700 font-semibold' : 'text-green-200 hover:text-white hover:bg-green-800' }}">
                   Semua Surat
                </a>
                
                @php
                    $jenisSurat = [
                        'Surat Keterangan Tidak Mampu' => 'SKTM',
                        'Surat Keterangan Usaha' => 'SKU (Usaha)',
                        'Surat Keterangan Domisili' => 'Domisili',
                        'Surat Pengantar SKCK' => 'Pengantar SKCK',
                        'Surat Keterangan Kelahiran' => 'Kelahiran',
                        'Surat Keterangan Kematian' => 'Kematian',
                        'Surat Keterangan Pindah' => 'Pindah',
                        'Surat Pengantar Nikah' => 'Nikah',
                        'Surat Pengajuan Tanah' => 'Tanah',
                    ];
                @endphp

                @foreach($jenisSurat as $key => $label)
                    <a href="{{ route('admin.surat.index', ['jenis' => $key]) }}" 
                       class="flex items-center justify-between px-3 py-2 rounded-md text-sm transition-colors duration-200 {{ request()->input('jenis') == $key ? 'text-white bg-green-700 font-semibold' : 'text-green-200 hover:text-white hover:bg-green-800' }}">
                        
                        <span>{{ $label }}</span>

                        @if(isset($notifPerJenis[$key]) && $notifPerJenis[$key] > 0)
                            <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                                {{ $notifPerJenis[$key] }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Keluhan Warga --}}
        <a href="{{ route('admin.keluhan.index') ?? '#' }}" 
           class="flex items-center justify-between px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.keluhan.*') ? 'bg-green-700 text-white shadow-sm' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
            <div class="flex items-center">
                <i class="ti ti-message-exclamation text-xl mr-3"></i>
                <span>Keluhan Warga</span>
            </div>
            
            {{-- Badge Keluhan --}}
            @if(isset($notifKeluhan) && $notifKeluhan > 0)
                <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
                    {{ $notifKeluhan }}
                </span>
            @endif
        </a>

        <div class="my-4 border-t border-green-800/50"></div>
        <p class="px-4 text-xs font-bold text-green-300 uppercase tracking-wider mb-2">Monitoring</p>

        {{-- Log Aktivitas --}}
        <a href="{{ route('admin.log.index') }}" 
           class="flex items-center px-4 py-2.5 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.log.*') ? 'bg-green-700 text-white shadow-sm' : 'text-green-100 hover:bg-green-800 hover:text-white' }}">
            <i class="ti ti-activity-heartbeat text-xl mr-3"></i>
            <span>Log Aktivitas</span>
        </a>

    </div>

    {{-- 3. FOOTER LOGOUT --}}
    <div class="p-4 border-t border-green-800 bg-green-900">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition-colors duration-200 shadow-sm">
                <i class="ti ti-logout text-lg mr-2"></i>
                Keluar
            </button>
        </form>
    </div>

</aside>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.plugin(collapse)
    })
</script>