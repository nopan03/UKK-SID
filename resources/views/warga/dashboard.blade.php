@extends('layouts.app')

@section('title', 'Dashboard Warga - Desa Suruh')

@section('content')

<div class="bg-gray-50 pt-40 pb-20 min-h-screen">
    <div class="container mx-auto px-6">
        <div class="md:pl-44">

            {{-- Sapaan Selamat Datang --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 bg-green-700 text-white p-6 rounded-xl shadow-lg">
                <div>
                    <h1 class="text-2xl font-bold">Halo, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-green-100 mt-1">Selamat datang di Dashboard Layanan Mandiri Desa Suruh.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('surat.index') }}" class="inline-flex items-center bg-primary-yellow text-gray-900 font-bold py-2 px-4 rounded-lg hover:bg-yellow-400 transition shadow">
                        <i class="ti ti-plus mr-2"></i> Buat Surat Baru
                    </a>
                </div>
            </div>

            {{-- Pesan Sukses (Muncul jika baru saja kirim surat) --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Tabel Riwayat Pengajuan --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h2 class="text-lg font-bold text-gray-800 flex items-center">
                        <i class="ti ti-history text-primary-yellow mr-2 text-xl"></i> Riwayat Pengajuan Surat
                    </h2>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Tanggal</th>
                                <th class="py-3 px-6">Jenis Surat</th>
                                <th class="py-3 px-6">Keperluan</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @forelse($suratSaya as $surat)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    {{-- Tanggal --}}
                                    <td class="py-3 px-6 whitespace-nowrap">
                                        {{ $surat->created_at->format('d M Y') }}
                                        <br>
                                        <span class="text-xs text-gray-400">{{ $surat->created_at->format('H:i') }} WIB</span>
                                    </td>
                                    
                                    {{-- Jenis Surat --}}
                                    <td class="py-3 px-6 font-medium text-gray-800">
                                        {{ strtoupper($surat->jenis_surat) }}
                                    </td>

                                    {{-- Keperluan (Dipotong jika kepanjangan) --}}
                                    <td class="py-3 px-6">
                                        {{ Str::limit($surat->keterangan, 40) }}
                                    </td>

                                    {{-- Status Badge --}}
                                    <td class="py-3 px-6 text-center">
                                        @if($surat->status == 'menunggu')
                                            <span class="bg-yellow-100 text-yellow-700 py-1 px-3 rounded-full text-xs font-bold">
                                                <i class="ti ti-clock"></i> Menunggu
                                            </span>
                                        @elseif($surat->status == 'diproses')
                                            <span class="bg-blue-100 text-blue-700 py-1 px-3 rounded-full text-xs font-bold">
                                                <i class="ti ti-loader"></i> Diproses
                                            </span>
                                        @elseif($surat->status == 'selesai')
                                            <span class="bg-green-100 text-green-700 py-1 px-3 rounded-full text-xs font-bold">
                                                <i class="ti ti-check"></i> Selesai
                                            </span>
                                        @elseif($surat->status == 'ditolak')
                                            <span class="bg-red-100 text-red-700 py-1 px-3 rounded-full text-xs font-bold">
                                                <i class="ti ti-x"></i> Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td class="py-3 px-6 text-center">
                                        <button class="text-gray-500 hover:text-green-600 transition">
                                            <i class="ti ti-eye text-lg"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                {{-- Jika Belum Ada Surat --}}
                                <tr>
                                    <td colspan="5" class="py-10 text-center text-gray-400">
                                        <i class="ti ti-folder-off text-4xl mb-2 block"></i>
                                        Belum ada riwayat pengajuan surat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection