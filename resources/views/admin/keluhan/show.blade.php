@extends('layouts.admin')

@section('title', 'Detail Laporan')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    {{-- Tombol Kembali --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Detail Laporan</h1>
            <p class="text-sm text-gray-500">Tinjau isi laporan dan berikan tanggapan.</p>
        </div>
        <a href="{{ route('admin.keluhan.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    {{-- ERROR ALERT (If update blocked) --}}
    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6 border-l-4 border-red-500 shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    {{-- SUCCESS ALERT --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 border-l-4 border-green-500 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KIRI: Info Laporan --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-gray-50">
                <h2 class="text-xl font-bold text-gray-800 mb-1">{{ $keluhan->judul }}</h2>
                <p class="text-xs text-gray-500 flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Dilaporkan pada {{ $keluhan->created_at->translatedFormat('d F Y, H:i') }} WIB
                </p>
            </div>
            
            <div class="p-6">
                {{-- Info Pelapor --}}
                <div class="grid grid-cols-2 gap-4 text-sm mb-6 bg-white border border-gray-200 p-4 rounded-lg">
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold mb-1">Nama Pelapor</p>
                        <p class="font-semibold text-gray-900">{{ $keluhan->user->name ?? 'User Terhapus' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs uppercase font-bold mb-1">Status Saat Ini</p>
                        @php
                            $status = strtolower($keluhan->status);
                        @endphp
                        @if($status == 'pending' || $status == 'menunggu')
                            <span class="text-yellow-600 font-bold uppercase">Menunggu</span>
                        @elseif($status == 'proses' || $status == 'diproses')
                            <span class="text-blue-600 font-bold uppercase">Diproses</span>
                        @elseif($status == 'selesai')
                            <span class="text-green-600 font-bold uppercase">Selesai</span>
                        @elseif($status == 'ditolak')
                            <span class="text-red-600 font-bold uppercase">Ditolak</span>
                        @endif
                    </div>
                </div>

                {{-- Isi Laporan --}}
                <div class="mb-6">
                    <p class="text-gray-500 text-sm font-bold mb-2 uppercase tracking-wider">Isi Laporan:</p>
                    <div class="bg-gray-50 p-4 rounded-lg text-gray-800 leading-relaxed whitespace-pre-line border border-gray-200 text-sm">
                        {{ $keluhan->isi }}
                    </div>
                </div>

                {{-- Bukti Foto --}}
                @if($keluhan->foto_bukti)
                    <div class="border-t pt-6">
                        <p class="text-gray-500 text-sm font-bold mb-3 uppercase tracking-wider">Bukti Foto:</p>
                        <a href="{{ asset('uploads/keluhan/' . $keluhan->foto_bukti) }}" target="_blank" class="group block w-fit relative overflow-hidden rounded-lg border border-gray-200 shadow-sm">
                            <img src="{{ asset('uploads/keluhan/' . $keluhan->foto_bukti) }}" alt="Bukti Laporan" class="max-h-80 object-cover transition transform group-hover:scale-105">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 flex items-center justify-center transition">
                                <span class="text-white font-bold opacity-0 group-hover:opacity-100 bg-black bg-opacity-50 px-3 py-1 rounded text-xs">Lihat Penuh</span>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="border-t pt-6 text-gray-400 italic text-sm">
                        Tidak ada foto bukti yang dilampirkan.
                    </div>
                @endif
            </div>
        </div>

        {{-- KANAN: Aksi Admin --}}
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-xl shadow border border-gray-100 sticky top-6">
                
                @php
                    $isLocked = in_array(strtolower($keluhan->status), ['selesai', 'ditolak']);
                @endphp

                @if($isLocked)
                    {{-- TAMPILAN JIKA STATUS SUDAH FINAL --}}
                    <div class="text-center py-6">
                        @if(strtolower($keluhan->status) == 'selesai')
                            <div class="mb-3 bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-8 h-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-green-700">Masalah Teratasi</h3>
                            <p class="text-sm text-gray-500 mt-2">Laporan ini telah ditandai selesai dan dikunci.</p>
                        @else
                            <div class="mb-3 bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto">
                                <svg class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-red-700">Laporan Ditolak</h3>
                            <p class="text-sm text-gray-500 mt-2">Laporan ini telah ditolak oleh admin.</p>
                        @endif
                    </div>

                @else
                    {{-- FORM UPDATE (Hanya Muncul Jika Belum Final) --}}
                    <h3 class="font-bold text-lg text-gray-800 mb-4 border-b pb-2">Tindakan Admin</h3>
                    
                    <form action="{{ route('admin.keluhan.update', $keluhan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Update Status:</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition shadow-sm">
                                <option value="pending" {{ ($keluhan->status == 'pending' || $keluhan->status == 'menunggu') ? 'selected' : '' }}>Menunggu (Belum Dibaca)</option>
                                <option value="diproses" {{ ($keluhan->status == 'proses' || $keluhan->status == 'diproses') ? 'selected' : '' }}>Sedang Diproses</option>
                                <option value="selesai" {{ $keluhan->status == 'selesai' ? 'selected' : '' }}>Selesai (Masalah Teratasi)</option>
                                <option value="ditolak" {{ $keluhan->status == 'ditolak' ? 'selected' : '' }}>Tolak Laporan</option>
                            </select>
                        </div>

                        <button type="submit" onclick="return confirm('Apakah Anda yakin? Jika status SELESAI, data akan dikunci.')" class="w-full bg-indigo-600 text-white py-2.5 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md flex justify-center items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </form>
                @endif

                <div class="mt-8 pt-6 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400 mb-3">Hapus jika laporan ini spam atau tidak valid.</p>
                    <form action="{{ route('admin.keluhan.destroy', $keluhan->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini secara permanen?');">
                        @csrf
                        @method('DELETE')
                        <button class="text-red-600 text-sm font-medium hover:text-red-800 hover:bg-red-50 py-2 px-4 rounded transition border border-transparent hover:border-red-100 w-full">
                            Hapus Laporan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection