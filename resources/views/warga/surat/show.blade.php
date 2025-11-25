@extends('layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('content')
<div class="bg-gray-50 pt-40 pb-20 min-h-screen">
    <div class="container mx-auto px-6">
        <div class="md:pl-44">

            {{-- Tombol Kembali --}}
            <a href="{{ route('warga.dashboard') }}" class="inline-flex items-center text-gray-600 hover:text-green-700 mb-6 transition">
                <i class="ti ti-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>

            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 max-w-4xl mx-auto">
                
                {{-- Header Status --}}
                <div class="px-8 py-6 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center bg-gray-50">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Detail Pengajuan</h1>
                        <p class="text-gray-500 text-sm mt-1">ID Pengajuan: #{{ $surat->id }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        @if($surat->status == 'menunggu')
                            <span class="bg-yellow-100 text-yellow-800 py-2 px-4 rounded-full font-bold text-sm flex items-center">
                                <i class="ti ti-clock mr-2"></i> Menunggu Verifikasi
                            </span>
                        @elseif($surat->status == 'selesai')
                            <span class="bg-green-100 text-green-800 py-2 px-4 rounded-full font-bold text-sm flex items-center">
                                <i class="ti ti-check mr-2"></i> Selesai / Terbit
                            </span>
                        @elseif($surat->status == 'ditolak')
                            <span class="bg-red-100 text-red-800 py-2 px-4 rounded-full font-bold text-sm flex items-center">
                                <i class="ti ti-x mr-2"></i> Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                <div class="p-8">
                    {{-- Info Utama --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jenis Surat</h3>
                            <p class="text-lg font-semibold text-gray-800">{{ strtoupper($surat->jenis_surat) }}</p>
                        </div>
                        <div>
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Pengajuan</h3>
                            <p class="text-lg font-semibold text-gray-800">{{ $surat->created_at->format('d F Y, H:i') }} WIB</p>
                        </div>
                        <div class="md:col-span-2">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Keperluan</h3>
                            <p class="text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                {{ $surat->keterangan }}
                            </p>
                        </div>
                    </div>

                    {{-- Detail Spesifik (Muncul sesuai data) --}}
                    @if($detail)
                        <div class="border-t border-gray-100 pt-8">
                            <h3 class="text-lg font-bold text-green-700 mb-4">Data Detail Surat</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                {{-- Loop otomatis semua kolom di tabel detail --}}
                                {{-- Kita sembunyikan kolom teknis seperti id, created_at, updated_at --}}
                                @foreach($detail->getAttributes() as $key => $value)
                                    @if(!in_array($key, ['id', 'surat_id', 'created_at', 'updated_at']))
                                        <div>
                                            <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">
                                                {{ str_replace('_', ' ', ucfirst($key)) }}
                                            </h4>
                                            <p class="text-gray-800 font-medium">
                                                {{ $value ? $value : '-' }}
                                            </p>
                                        </div>
                                    @endif
                                @endforeach

                            </div>
                        </div>
                    @endif

                </div>
                
                {{-- Footer / Aksi --}}
                @if($surat->status == 'selesai')
                    <div class="bg-gray-50 px-8 py-4 border-t border-gray-200 text-right">
                        <button class="bg-green-700 text-white font-bold py-2 px-6 rounded-lg hover:bg-green-800 transition shadow">
                            <i class="ti ti-printer mr-2"></i> Cetak Surat
                        </button>
                    </div>
                @endif

            </div>

        </div>
    </div>
</div>
@endsection