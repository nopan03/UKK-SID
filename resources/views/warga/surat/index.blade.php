@extends('layouts.app')

@section('title', 'Layanan Administrasi Surat - Desa Suruh')

@section('content')

    {{-- 
       REVISI: 
       - Mengubah pt-20 menjadi pt-10 (agar tidak terlalu turun).
       - bg-gray-50 tetap dipertahankan agar kotak putih terlihat kontras.
    --}}
    <div class="bg-gray-50 pt-10 pb-20 min-h-screen" 
         x-data="{ 
            selectedSurat: '', 
            
            suratData: {
                'sktm': {
                    judul: 'Surat Keterangan Tidak Mampu (SKTM)',
                    deskripsi: 'Digunakan untuk persyaratan beasiswa, bantuan kesehatan (BPJS/KIS), atau bantuan sosial.',
                    syarat: ['Fotokopi KTP Pemohon', 'Fotokopi Kartu Keluarga (KK)', 'Surat Pengantar RT/RW'],
                    icon: 'ti-file-certificate'
                },
                'sku': {
                    judul: 'Surat Keterangan Usaha (SKU)',
                    deskripsi: 'Menerangkan kepemilikan usaha untuk persyaratan pinjaman bank (KUR) atau legalitas.',
                    syarat: ['Fotokopi KTP & KK', 'Surat Pengantar RT/RW', 'Bukti Kegiatan Usaha'],
                    icon: 'ti-building-store'
                },
                'domisili': {
                    judul: 'Surat Keterangan Domisili',
                    deskripsi: 'Menerangkan tempat tinggal warga pendatang atau yang belum ber-KTP setempat.',
                    syarat: ['Fotokopi KTP Asal', 'Fotokopi KK', 'Surat Pengantar RT/RW Domisili', 'Pas Foto 3x4'],
                    icon: 'ti-map-pin'
                },
                'skck': {
                    judul: 'Surat Pengantar SKCK',
                    deskripsi: 'Surat pengantar ke Polsek/Polres untuk pembuatan SKCK.',
                    syarat: ['Fotokopi KTP & KK', 'Fotokopi Akta Kelahiran', 'Surat Pengantar RT/RW'],
                    icon: 'ti-shield-check'
                },
                'kelahiran': {
                    judul: 'Surat Keterangan Kelahiran',
                    deskripsi: 'Untuk pembuatan Akta Kelahiran bayi di Disdukcapil.',
                    syarat: ['Surat Lahir Bidan/RS (Asli)', 'KTP & KK Orang Tua', 'Buku Nikah Orang Tua'],
                    icon: 'ti-baby-carriage'
                },
                'kematian': {
                    judul: 'Surat Keterangan Kematian',
                    deskripsi: 'Untuk pembuatan Akta Kematian atau klaim waris/asuransi.',
                    syarat: ['Surat Kematian Dokter (jika ada)', 'KTP & KK Almarhum', 'KTP Pelapor'],
                    icon: 'ti-activity-heartbeat'
                }
            }
         }">

        <div class="container mx-auto px-6">
            
            <div class="md:pl-15">

                {{-- Header --}}
                {{-- REVISI: Mengubah mb-8 menjadi mb-4 agar lebih dekat dengan kotak di bawahnya --}}
                <div class="text-center mb-4">
                    <h1 class="text-4xl font-bold text-green-700 mb-2">Layanan Administrasi Surat</h1>
                    <p class="text-gray-600 text-lg">Layanan mandiri pembuatan surat keterangan desa secara online.</p>
                </div>

                {{-- 1. BAGIAN PILIH SURAT --}}
                <div class="bg-white p-8 rounded-xl shadow-md border-t-4 border-green-600 mb-8 max-w-4xl mx-auto">
                    <label class="block text-lg font-semibold text-gray-800 mb-4 text-center">
                        Silakan Pilih Jenis Surat yang Ingin Dibuat:
                    </label>
                    
                    <div class="relative max-w-2xl mx-auto">
                        <select x-model="selectedSurat" 
                            class="block w-full pl-5 pr-10 py-4 text-lg border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 rounded-lg shadow-sm bg-gray-50 cursor-pointer">
                            <option value="" disabled selected>-- Klik disini untuk memilih surat --</option>
                            <option value="sktm">Surat Keterangan Tidak Mampu (SKTM)</option>
                            <option value="sku">Surat Keterangan Usaha (SKU)</option>
                            <option value="domisili">Surat Keterangan Domisili</option>
                            <option value="skck">Surat Pengantar SKCK</option>
                            <option value="kelahiran">Surat Keterangan Kelahiran</option>
                            <option value="kematian">Surat Keterangan Kematian</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                            <i class="ti ti-chevron-down text-xl"></i>
                        </div>
                    </div>

                    <p class="text-center text-gray-500 text-sm mt-4 flex items-center justify-center gap-2">
                        <i class="ti ti-info-circle"></i> Pastikan Anda sudah login untuk melanjutkan pengajuan.
                    </p>
                </div>

                {{-- 2. BAGIAN DETAIL --}}
                <div x-show="selectedSurat" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-10"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="max-w-4xl mx-auto"
                     style="display: none;">
                    
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                        
                        <div class="bg-green-50 p-6 border-b border-green-100 flex items-center justify-center md:justify-start">
                            <div class="p-3 bg-white rounded-full shadow-sm text-green-700 mr-4 hidden md:block">
                                <i :class="'ti ' + suratData[selectedSurat].icon" class="text-4xl"></i>
                            </div>
                            <div class="text-center md:text-left">
                                <h2 class="text-2xl md:text-3xl font-bold text-gray-800" x-text="suratData[selectedSurat].judul"></h2>
                                <span class="text-sm text-green-700 font-medium bg-green-100 px-3 py-1 rounded-full mt-2 inline-block">Persyaratan & Ketentuan</span>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3 text-sm font-bold">1</div>
                                        Kegunaan Surat
                                    </h3>
                                    <p class="text-gray-600 leading-relaxed pl-11" x-text="suratData[selectedSurat].deskripsi"></p>
                                </div>

                                <div>
                                    <h3 class="text-lg font-bold text-gray-800 mb-3 flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center mr-3 text-sm font-bold">2</div>
                                        Dokumen Persyaratan
                                    </h3>
                                    <ul class="space-y-2 pl-11">
                                        <template x-for="syarat in suratData[selectedSurat].syarat">
                                            <li class="flex items-start text-gray-700">
                                                <i class="ti ti-check text-green-600 mt-1 mr-2"></i> <span x-text="syarat"></span>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            <div class="mt-10 pt-8 border-t border-gray-100 text-center">
                                @guest
                                    <a href="{{ route('login') }}" class="inline-block bg-gray-200 text-gray-600 font-bold py-3 px-8 rounded-full hover:bg-gray-300 transition">
                                        <i class="ti ti-lock mr-2"></i> Login untuk Melanjutkan
                                    </a>
                                @else
                                    <a :href="'{{ url('/surat/buat') }}/' + selectedSurat"
                                       class="inline-block bg-primary-yellow text-gray-900 font-bold py-4 px-10 rounded-full hover:bg-yellow-400 shadow-lg hover:shadow-xl transition transform hover:-translate-y-1 text-lg">
                                        <i class="ti ti-pencil mr-2"></i> Isi Formulir Pengajuan
                                    </a>
                                @endauth
                            </div>

                        </div>
                    </div>
                </div>

                <div x-show="!selectedSurat" class="text-center py-20 opacity-50">
                    <i class="ti ti-files text-6xl text-gray-300 mb-4 block"></i>
                    <p class="text-gray-500">Silakan pilih jenis surat di atas untuk melihat detail.</p>
                </div>

            </div>
        </div>
    </div>

@endsection