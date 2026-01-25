@extends('layouts.app')

@section('title', 'Layanan Administrasi Surat')

@section('content')

    <div class="bg-gray-50 pt-10 pb-20 min-h-screen" 
         x-data="{ 
            selectedSurat: '', 
            open: false, 
            
            // DATA SURAT
            suratData: {
                'Surat Keterangan Tidak Mampu': {
                    icon: 'ti-file-certificate',
                    deskripsi: 'Digunakan untuk persyaratan beasiswa, bantuan kesehatan (BPJS/KIS), atau bantuan sosial.',
                    syarat: ['Fotokopi KTP Pemohon', 'Fotokopi Kartu Keluarga (KK)', 'Surat Pengantar RT/RW']
                },
                'Surat Keterangan Usaha': {
                    icon: 'ti-building-store',
                    deskripsi: 'Menerangkan kepemilikan usaha untuk persyaratan pinjaman bank (KUR) atau legalitas.',
                    syarat: ['Fotokopi KTP & KK', 'Surat Pengantar RT/RW', 'Bukti Kegiatan Usaha']
                },
                'Surat Keterangan Domisili': {
                    icon: 'ti-map-pin',
                    deskripsi: 'Menerangkan tempat tinggal warga pendatang atau yang belum ber-KTP setempat.',
                    syarat: ['Fotokopi KTP Asal', 'Fotokopi KK', 'Surat Pengantar RT/RW Domisili', 'Pas Foto 3x4']
                },
                'Surat Pengantar SKCK': {
                    icon: 'ti-shield-check',
                    deskripsi: 'Surat pengantar ke Polsek/Polres untuk pembuatan SKCK.',
                    syarat: ['Fotokopi KTP & KK', 'Fotokopi Akta Kelahiran', 'Surat Pengantar RT/RW']
                },
                'Surat Keterangan Kelahiran': {
                    icon: 'ti-baby-carriage',
                    deskripsi: 'Untuk pembuatan Akta Kelahiran bayi di Disdukcapil.',
                    syarat: ['Surat Lahir Bidan/RS (Asli)', 'KTP & KK Orang Tua', 'Buku Nikah Orang Tua']
                },
                'Surat Keterangan Pindah': {
                    icon: 'ti-truck-delivery',
                    deskripsi: 'Surat pengantar untuk warga yang akan pindah domisili ke luar daerah.',
                    syarat: ['KTP & KK Asli', 'Alamat Tujuan Lengkap']
                },
                'Surat Pengantar Nikah': {
                    icon: 'ti-rings-wedding',
                    deskripsi: 'Surat pengantar (N1-N4) untuk pendaftaran pernikahan di KUA.',
                    syarat: ['Fotokopi KTP & KK Calon', 'Fotokopi Akta Kelahiran', 'Fotokopi Ijazah Terakhir']
                },
                'Surat Pengajuan Tanah': {
                    icon: 'ti-map',
                    deskripsi: 'Surat keterangan terkait kepemilikan atau pengajuan sertifikat tanah.',
                    syarat: ['Fotokopi KTP & KK', 'Bukti Kepemilikan Tanah (Letter C/Girik)', 'SPPT PBB Terakhir']
                }
            }
         }">

        <div class="container mx-auto px-4 md:px-6">
            <div class="md:pl-15">

                {{-- Header --}}
                <div class="text-center mb-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-green-700 mb-3">Layanan Administrasi Surat</h1>
                    <p class="text-gray-600 text-sm md:text-base">Pilih jenis layanan surat yang Anda butuhkan di bawah ini.</p>
                </div>

                {{-- KOTAK PILIHAN (CUSTOM DROPDOWN) --}}
                {{-- z-30 agar dropdown muncul di atas elemen lain --}}
                <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-green-600 mb-8 max-w-3xl mx-auto relative z-30">
                    
                    <label class="block text-lg font-bold text-gray-800 mb-4 text-center">
                        Pilih Jenis Surat:
                    </label>
                    
                    {{-- Wrapper Dropdown --}}
                    <div class="relative w-full">
                        
                        {{-- 1. TOMBOL PEMICU (Menggantikan Select Biasa) --}}
                        <button @click="open = !open" 
                                @click.outside="open = false"
                                type="button" 
                                class="w-full bg-gray-50 border-2 border-gray-300 text-left px-4 py-3 md:py-4 rounded-lg shadow-sm flex justify-between items-center hover:border-green-500 transition focus:outline-none focus:ring-4 focus:ring-green-100">
                            
                            {{-- Teks Pilihan --}}
                            <span class="text-base md:text-lg font-medium truncate pr-2" 
                                  :class="selectedSurat ? 'text-gray-900' : 'text-gray-500'"
                                  x-text="selectedSurat ? selectedSurat : '-- Klik Disini Untuk Memilih --'">
                            </span>
                            
                            {{-- Ikon Panah --}}
                            <svg class="w-5 h-5 text-gray-500 transition-transform duration-200 flex-shrink-0" 
                                 :class="open ? 'transform rotate-180 text-green-600' : ''"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        {{-- 2. DAFTAR MENU (Dropdown List) --}}
                        {{-- Class 'top-full' memaksa menu muncul DI BAWAH tombol --}}
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             class="absolute z-50 top-full left-0 mt-2 w-full bg-white border border-gray-200 rounded-lg shadow-2xl max-h-72 overflow-y-auto"
                             style="display: none;">
                            
                            <ul>
                                <template x-for="(data, name) in suratData" :key="name">
                                    <li @click="selectedSurat = name; open = false"
                                        class="px-4 py-3 md:py-4 hover:bg-green-50 cursor-pointer border-b border-gray-100 last:border-none flex items-center transition group">
                                        
                                        {{-- Ikon --}}
                                        <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center mr-3 flex-shrink-0 group-hover:bg-green-100 group-hover:text-green-600 transition">
                                            <i :class="'ti ' + data.icon"></i>
                                        </div>
                                        
                                        {{-- Nama Surat --}}
                                        <span class="text-sm md:text-base text-gray-800 font-medium group-hover:text-green-700 transition" x-text="name"></span>
                                        
                                        {{-- Centang --}}
                                        <span x-show="selectedSurat === name" class="ml-auto text-green-600 font-bold">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </span>
                                    </li>
                                </template>
                            </ul>
                        </div>

                    </div>
                </div>

                {{-- BAGIAN DETAIL SURAT --}}
                <div x-show="selectedSurat" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-10"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="max-w-4xl mx-auto relative z-10"
                     style="display: none;">
                    
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
                        
                        {{-- Header Detail --}}
                        <div class="bg-green-50 p-5 md:p-6 border-b border-green-100 flex flex-col md:flex-row items-center md:items-start text-center md:text-left">
                            <div class="p-3 md:p-4 bg-white rounded-full shadow-sm text-green-700 mb-3 md:mb-0 md:mr-6">
                                <i :class="'ti ' + (suratData[selectedSurat] ? suratData[selectedSurat].icon : 'ti-file')" class="text-4xl md:text-5xl"></i>
                            </div>
                            <div>
                                <h2 class="text-xl md:text-3xl font-bold text-gray-800 leading-tight mb-2" x-text="selectedSurat"></h2>
                                <span class="text-xs font-bold text-green-800 bg-green-200 px-3 py-1 rounded-full inline-block">Persyaratan & Ketentuan</span>
                            </div>
                        </div>

                        <div class="p-6 md:p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                
                                {{-- Kolom Kiri --}}
                                <div>
                                    <h3 class="font-bold text-gray-800 mb-3 flex items-center text-base md:text-lg">
                                        <span class="bg-yellow-400 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 text-xs">1</span>
                                        Kegunaan
                                    </h3>
                                    <p class="text-gray-600 ml-8 text-sm md:text-base leading-relaxed" 
                                       x-text="suratData[selectedSurat] ? suratData[selectedSurat].deskripsi : ''"></p>
                                </div>

                                {{-- Kolom Kanan --}}
                                <div>
                                    <h3 class="font-bold text-gray-800 mb-3 flex items-center text-base md:text-lg">
                                        <span class="bg-yellow-400 text-white w-6 h-6 rounded-full flex items-center justify-center mr-2 text-xs">2</span>
                                        Dokumen Syarat
                                    </h3>
                                    <ul class="ml-8 space-y-2">
                                        <template x-for="syarat in (suratData[selectedSurat] ? suratData[selectedSurat].syarat : [])">
                                            <li class="flex items-start text-gray-600 text-sm md:text-base">
                                                <svg class="w-4 h-4 text-green-600 mt-1 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> 
                                                <span x-text="syarat"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            {{-- Tombol Lanjut --}}
                            <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                                @auth
                                    <a :href="'{{ url('/surat/buat') }}/' + encodeURIComponent(selectedSurat)"
                                       class="inline-flex items-center justify-center w-full md:w-auto bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-bold py-3 px-8 rounded-full shadow-lg transform transition hover:-translate-y-1 text-base md:text-lg">
                                        <span class="mr-2">Isi Formulir Sekarang</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-gray-800 hover:bg-gray-900 text-white font-bold py-3 px-8 rounded-full shadow-md transition w-full md:w-auto">
                                        Login untuk Melanjutkan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Placeholder --}}
                <div x-show="!selectedSurat" class="text-center py-20 opacity-50">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <p class="text-gray-500">Silakan pilih jenis surat di atas.</p>
                </div>

            </div>
        </div>
    </div>

@endsection