@extends('layouts.admin') {{-- 1. UBAH INI: Gunakan Layout Admin agar ada Sidebar --}}

@section('title', 'Detail Data Warga')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- Header Sederhana --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Data Warga</h1>
        <p class="text-sm text-gray-500">Informasi lengkap penduduk atas nama <span class="font-bold text-green-700">{{ $warga->nama }}</span>.</p>
    </div>

    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">
        <div class="p-6 md:p-8 text-gray-900">
            
            {{-- Menggunakan grid untuk tata letak 2 kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-8">
                
                {{-- Baris 1 --}}
                <div class="border-b pb-2 md:border-none md:pb-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">NIK</p>
                    <p class="font-bold text-xl text-gray-800 tracking-wide">{{ $warga->nik }}</p>
                </div>

                <div class="border-b pb-2 md:border-none md:pb-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="font-bold text-xl text-gray-800">{{ $warga->nama }}</p>
                </div>

                {{-- Baris 2 --}}
                <div class="border-b pb-2 md:border-none md:pb-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</p>
                    <p class="font-semibold text-gray-700">
                        {{ $warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d F Y') }}
                    </p>
                </div>

                <div class="border-b pb-2 md:border-none md:pb-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Jenis Kelamin</p>
                    <p class="font-semibold text-gray-700">
                        @if($warga->jenis_kelamin == 'L')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Laki-laki
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">
                                Perempuan
                            </span>
                        @endif
                    </p>
                </div>

                {{-- Baris 3 --}}
                <div class="border-b pb-2 md:border-none md:pb-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Agama</p>
                    <p class="font-semibold text-gray-700">{{ $warga->agama }}</p>
                </div>
                 
                 <div class="border-b pb-2 md:border-none md:pb-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Status Perkawinan</p>
                    <p class="font-semibold text-gray-700">{{ $warga->status_perkawinan }}</p>
                </div>

                {{-- Baris 4 --}}
                <div class="border-b pb-2 md:border-none md:pb-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Pekerjaan</p>
                    <p class="font-semibold text-gray-700">{{ $warga->pekerjaan }}</p>
                </div>

                <div class="border-b pb-2 md:border-none md:pb-0">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Status Hidup</p>
                    <p class="font-semibold capitalize">
                        @if($warga->status_hidup == 'hidup')
                            <span class="text-green-600 font-bold flex items-center">
                                <span class="w-2 h-2 rounded-full bg-green-600 mr-2"></span> Hidup
                            </span>
                        @else
                            <span class="text-red-600 font-bold flex items-center">
                                <span class="w-2 h-2 rounded-full bg-red-600 mr-2"></span> Meninggal
                            </span>
                        @endif
                    </p>
                </div>

                {{-- Alamat (Full Width) --}}
                 <div class="md:col-span-2 bg-gray-50 p-4 rounded-lg">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Alamat Lengkap</p>
                    <p class="font-medium text-gray-800">{{ $warga->alamat }}</p>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-between mt-8 border-t pt-6">
                {{-- 2. UBAH LINK KEMBALI: Arahkan ke Tabel Warga (index), bukan Dashboard --}}
                <a href="{{ route('admin.warga.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali
                </a>

                {{-- Tombol Edit (Opsional, agar admin mudah navigasi) --}}
                <a href="{{ route('admin.warga.edit', $warga->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Edit Data
                </a>
            </div>

        </div>
    </div>
</div>
@endsection