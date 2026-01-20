@extends('layouts.admin')

@section('title', 'Tulis Berita Baru')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER HALAMAN --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tulis Berita Baru</h1>
        <p class="text-sm text-gray-500">Buat artikel, pengumuman, atau agenda kegiatan desa.</p>
    </div>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">

            <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 gap-6">

                    {{-- Judul Berita --}}
                    <div>
                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Berita</label>
                        <input type="text" id="judul" name="judul" value="{{ old('judul') }}" required autofocus
                            placeholder="Contoh: Jadwal Posyandu Balita"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                        @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Grid 2 Kolom --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Kategori --}}
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                            <select id="kategori" name="kategori" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                                <option value="Berita Desa" {{ old('kategori') == 'Berita Desa' ? 'selected' : '' }}>Berita Desa</option>
                                <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                                <option value="Agenda" {{ old('kategori') == 'Agenda' ? 'selected' : '' }}>Agenda Kegiatan</option>
                                <option value="Potensi Desa" {{ old('kategori') == 'Potensi Desa' ? 'selected' : '' }}>Potensi Desa</option>
                            </select>
                            @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        {{-- 🔥 TANGGAL PUBLIKASI (SUDAH DIPERBAIKI) 🔥 --}}
                        <div>
                            <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Publikasi</label>
                            <input 
                                type="date" 
                                id="tanggal" 
                                name="tanggal" 
                                {{-- Value otomatis hari ini --}}
                                value="{{ date('Y-m-d') }}" 
                                {{-- Class diganti jadi abu-abu (bg-gray-200) dan kursor dilarang --}}
                                class="w-full rounded-lg border-gray-300 bg-gray-200 text-gray-500 cursor-not-allowed focus:ring-0"
                                {{-- Kunci input agar tidak bisa diklik --}}
                                readonly
                            >
                            <p class="text-xs text-gray-400 mt-1">*Tanggal otomatis terkunci hari ini.</p>
                            @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Upload Gambar --}}
                    <div>
                        <label for="gambar" class="block text-sm font-medium text-gray-700 mb-1">Gambar Utama (Opsional)</label>
                        <input type="file" id="gambar" name="gambar" accept="image/*"
                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-lg cursor-pointer">
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, GIF. Maksimal 2MB.</p>
                        @error('gambar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Isi Berita (KEMBALI KE TEXTAREA YANG ANDA SUKA) --}}
                    <div>
                        <label for="isi" class="block text-sm font-medium text-gray-700 mb-1">Isi Berita</label>
                        <textarea id="isi" name="isi" rows="10" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200"
                            placeholder="Tuliskan isi berita lengkap di sini...">{{ old('isi') }}</textarea>
                        @error('isi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex items-center justify-end mt-8 border-t pt-6 space-x-4">
                    <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-semibold">
                        Batal
                    </a>
                    
                    <button type="submit" class="px-6 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition text-sm font-semibold shadow-md flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Terbitkan Berita
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection