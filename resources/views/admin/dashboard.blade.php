@extends('layouts.admin') {{-- PENTING: Panggil Layout Admin --}}

@section('title', 'Dashboard Admin')
@section('header', 'Overview Dashboard')

@section('content')
    
    {{-- 1. KARTU STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- Warga --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500 flex items-center">
            <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                <i class="ti ti-users text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase">Total Warga</p>
                <p class="text-2xl font-extrabold text-gray-800">{{ number_format($totalWarga) }}</p>
            </div>
        </div>

        {{-- Surat Menunggu --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500 flex items-center">
            <div class="p-3 rounded-full bg-yellow-50 text-yellow-600 mr-4">
                <i class="ti ti-file-alert text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase">Surat Menunggu</p>
                <p class="text-2xl font-extrabold text-gray-800">{{ number_format($suratMenunggu) }}</p>
            </div>
        </div>

        {{-- Berita --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500 flex items-center">
            <div class="p-3 rounded-full bg-green-50 text-green-600 mr-4">
                <i class="ti ti-news text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase">Berita</p>
                <p class="text-2xl font-extrabold text-gray-800">{{ number_format($totalBerita) }}</p>
            </div>
        </div>

        {{-- Keuangan --}}
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500 flex items-center">
            <div class="p-3 rounded-full bg-purple-50 text-purple-600 mr-4">
                <i class="ti ti-wallet text-3xl"></i>
            </div>
            <div>
                <p class="text-gray-400 text-xs font-bold uppercase">Keuangan</p>
                <p class="text-xl font-extrabold text-gray-800">Active</p>
            </div>
        </div>
    </div>

    {{-- 2. TABEL SURAT MASUK (Gantikan Menu Ikon) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Tabel Surat --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                <h3 class="font-bold text-gray-800 flex items-center">
                    <i class="ti ti-mail-forward text-yellow-500 mr-2 text-xl"></i> 
                    Permohonan Surat Baru
                </h3>
                <a href="{{ route('admin.surat.index') }}" class="text-sm text-blue-600 hover:underline font-medium">Lihat Semua &rarr;</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3">Pemohon</th>
                            <th class="px-6 py-3">Jenis</th>
                            <th class="px-6 py-3">Tanggal</th>
                            <th class="px-6 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($suratMasuk as $surat)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 font-medium text-gray-900">
                                {{ $surat->user->name }}
                            </td>
                            <td class="px-6 py-3">
                                <span class="bg-yellow-100 text-yellow-700 py-1 px-2 rounded text-xs font-bold uppercase">
                                    {{ $surat->jenis_surat }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-500 text-xs">
                                {{ $surat->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-3 text-center">
                                <a href="{{ route('admin.surat.show', $surat->id) }}" class="text-blue-600 hover:underline font-semibold">Proses</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400">
                                Tidak ada surat baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Keluhan (Placeholder) --}}
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h3 class="font-bold text-gray-800 flex items-center">
                    <i class="ti ti-message-exclamation text-red-500 mr-2 text-xl"></i> 
                    Keluhan Masuk
                </h3>
            </div>
            <div class="p-8 text-center">
                <i class="ti ti-check-up-list text-gray-300 text-5xl mb-3 block"></i>
                <p class="text-gray-500 text-sm">Belum ada keluhan.</p>
            </div>
        </div>

    </div>

@endsection