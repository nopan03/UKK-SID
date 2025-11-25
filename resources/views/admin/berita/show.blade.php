@extends('layouts.admin') {{-- 1. GUNAKAN LAYOUT ADMIN --}}

@section('title', 'Detail Berita')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Preview Berita</h1>
            <p class="text-sm text-gray-500">Tampilan detail berita yang akan dilihat warga.</p>
        </div>
        
        {{-- Tombol Edit Cepat --}}
        <a href="{{ route('admin.berita.edit', $berita->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition text-sm font-semibold shadow-md">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Berita Ini
        </a>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100">

            {{-- GAMBAR UTAMA (Cek jika ada gambar) --}}
            @if($berita->gambar)
                <div class="w-full h-96 overflow-hidden">
                    <img class="w-full h-full object-cover object-center transform hover:scale-105 transition duration-500" 
                         src="{{ asset('storage/' . $berita->gambar) }}" 
                         alt="{{ $berita->judul }}">
                </div>
            @else
                {{-- Fallback jika tidak ada gambar --}}
                <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>Tidak ada gambar thumbnail</span>
                    </div>
                </div>
            @endif

            <div class="p-6 sm:p-10">
                
                {{-- Kategori Badge --}}
                <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-bold mb-3 uppercase tracking-wide">
                    {{ $berita->kategori }}
                </span>

                {{-- Judul --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    {{ $berita->judul }}
                </h1>

                {{-- Meta Data (Penulis & Tanggal) --}}
                <div class="flex items-center text-sm text-gray-500 space-x-6 mb-8 border-b border-gray-100 pb-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        <span class="font-medium">{{ $berita->user->name ?? 'Admin Desa' }}</span>
                    </div>
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($berita->created_at)->translatedFormat('d F Y') }}</span>
                    </div>
                </div>

                {{-- ISI BERITA --}}
                <div class="prose max-w-none text-gray-800 leading-relaxed">
                    {{-- nl2br: Mengubah enter menjadi paragraf baru --}}
                    {!! nl2br(e($berita->isi)) !!}
                </div>

                {{-- TOMBOL KEMBALI --}}
                <div class="mt-10 pt-6 border-t border-gray-100 flex justify-between items-center">
                    <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center text-gray-600 hover:text-green-700 font-medium transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Kembali ke Daftar Berita
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection