@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

    {{-- KARTU STATISTIK (Row 1) --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        
        {{-- Total Warga --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Warga</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalWarga }}</p>
            </div>
            <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                <i class="ti ti-users text-2xl"></i>
            </div>
        </div>

        {{-- Surat Menunggu --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Surat Menunggu</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $suratMenunggu }}</p>
            </div>
            <div class="p-3 bg-yellow-50 rounded-full text-yellow-600">
                <i class="ti ti-file-alert text-2xl"></i>
            </div>
        </div>

        {{-- Berita --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Berita</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalBerita }}</p>
            </div>
            <div class="p-3 bg-green-50 rounded-full text-green-600">
                <i class="ti ti-news text-2xl"></i>
            </div>
        </div>

        {{-- Keuangan (Contoh Statis) --}}
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Keuangan</p>
                <p class="text-xl font-bold text-gray-800 mt-1">Active</p>
            </div>
            <div class="p-3 bg-purple-50 rounded-full text-purple-600">
                <i class="ti ti-wallet text-2xl"></i>
            </div>
        </div>
    </div>

    {{-- KONTEN UTAMA (Row 2) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- TABEL SURAT BARU (Kiri - Lebar 2 Kolom) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 flex items-center">
                    <i class="ti ti-mail-opened mr-2 text-yellow-500"></i> Permohonan Surat Baru
                </h3>
                <a href="{{ route('admin.surat.index') }}" class="text-sm text-blue-600 hover:underline">Lihat Semua &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 font-bold">
                        <tr>
                            <th class="px-6 py-3">Pemohon</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($suratTerbaru as $surat)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 font-medium text-gray-900">{{ $surat->user->name ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded font-bold uppercase text-[10px]">
                                        {{ Str::limit($surat->jenis_surat, 20) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $surat->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('admin.surat.show', $surat->id) }}" class="text-blue-600 hover:text-blue-800 font-bold text-xs">Proses</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-400">Belum ada surat masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- WIDGET KELUHAN MASUK (Kanan - Lebar 1 Kolom) --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden h-fit">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h3 class="font-bold text-gray-800 flex items-center">
                    <i class="ti ti-message-exclamation mr-2 text-red-500"></i> Keluhan Masuk
                </h3>
                {{-- Pastikan route ini ada --}}
                @if(Route::has('admin.keluhan.index'))
                    <a href="{{ route('admin.keluhan.index') }}" class="text-xs font-bold text-gray-400 hover:text-gray-600">Lihat</a>
                @endif
            </div>

            <div class="p-0">
                @forelse($keluhanTerbaru as $keluhan)
                    <div class="p-4 border-b border-gray-50 hover:bg-gray-50 transition group relative">
                        <div class="flex justify-between items-start mb-1">
                            <span class="text-xs font-bold text-gray-500">{{ $keluhan->created_at->diffForHumans() }}</span>
                            @if($keluhan->status == 'pending')
                                <span class="w-2 h-2 bg-red-500 rounded-full" title="Pending"></span>
                            @else
                                <span class="w-2 h-2 bg-blue-500 rounded-full" title="Proses"></span>
                            @endif
                        </div>
                        
                        <h4 class="font-bold text-gray-800 text-sm mb-1 group-hover:text-blue-600 transition">
                            {{ Str::limit($keluhan->judul, 30) }}
                        </h4>
                        
                        <p class="text-xs text-gray-500 line-clamp-2">
                            {{ $keluhan->isi }}
                        </p>

                        {{-- Link tersembunyi (Klik seluruh kotak) --}}
                        @if(Route::has('admin.keluhan.show'))
                            <a href="{{ route('admin.keluhan.show', $keluhan->id) }}" class="absolute inset-0"></a>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="bg-green-50 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3 text-green-500">
                            <i class="ti ti-check text-xl"></i>
                        </div>
                        <p class="text-gray-500 text-sm">Tidak ada keluhan baru.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

@endsection