@extends('layouts.app')

@section('title', 'Riwayat Pengajuan')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen pt-32"> {{-- pt-32 agar turun dibawah navbar fixed --}}
    <div class="container mx-auto px-4 md:px-6 max-w-5xl">
        
        {{-- Header Halaman --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Riwayat Pengajuan Surat</h1>
                <p class="text-gray-500 mt-1">Pantau status permohonan surat keterangan Anda di sini.</p>
            </div>
            <a href="{{ route('surat.index') }}" class="mt-4 md:mt-0 inline-flex items-center px-5 py-2.5 bg-green-600 text-white font-bold rounded-full shadow-lg hover:bg-green-700 transition transform hover:-translate-y-1">
                <i class="ti ti-plus mr-2"></i> Buat Pengajuan Baru
            </a>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-sm flex items-center animate-fade-in-down">
                <i class="ti ti-check-circle text-xl mr-3"></i>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        {{-- Tabel Riwayat --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            
            @if($suratSaya->isEmpty())
                {{-- Tampilan Kosong --}}
                <div class="p-12 text-center">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                        <i class="ti ti-files text-4xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Belum ada riwayat pengajuan</h3>
                    <p class="text-gray-500 mt-2">Anda belum pernah mengajukan surat apapun. Silakan buat pengajuan baru.</p>
                </div>
            @else
                {{-- Tampilan Tabel Desktop --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-600 font-bold border-b border-gray-200 uppercase text-xs">
                            <tr>
                                <th class="px-6 py-4">Jenis Surat</th>
                                <th class="px-6 py-4">Tanggal Request</th>
                                <th class="px-6 py-4">Keterangan</th>
                                <th class="px-6 py-4 text-center">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($suratSaya as $surat)
                                <tr class="hover:bg-green-50/50 transition">
                                    
                                    {{-- Jenis Surat --}}
                                    <td class="px-6 py-4 font-medium text-gray-900">
                                        {{ $surat->jenis_surat }}
                                    </td>

                                    {{-- Tanggal --}}
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $surat->created_at->format('d M Y, H:i') }} WIB
                                    </td>

                                    {{-- Keterangan --}}
                                    <td class="px-6 py-4 text-gray-600 max-w-xs truncate">
                                        {{ $surat->keterangan }}
                                    </td>

                                    {{-- Status Badge --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($surat->status == 'menunggu')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5"></span> Menunggu
                                            </span>
                                        @elseif($surat->status == 'proses')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-1.5 animate-pulse"></span> Diproses
                                            </span>
                                        @elseif($surat->status == 'selesai')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span> Selesai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500 mr-1.5"></span> Ditolak
                                            </span>
                                        @endif
                                    </td>

                                    {{-- Tombol Aksi --}}
                                    <td class="px-6 py-4 text-center">
                                        @if($surat->status == 'selesai' && $surat->file_surat)
                                            {{-- Tombol Download --}}
                                            <a href="{{ route('admin.surat.pdf', $surat->id) }}"
                                            target="_blank"
                                            class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-xs font-bold rounded-lg hover:bg-green-700 transition shadow-sm">
                                                <i class="ti ti-download mr-1.5"></i> Unduh PDF
                                            </a>
                                        @elseif($surat->status == 'selesai')
                                            <span class="text-xs text-gray-500 italic">Ambil fisik di Balai Desa</span>
                                        @elseif($surat->status == 'ditolak')
                                            {{-- dst --}}
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection