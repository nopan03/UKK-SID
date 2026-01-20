@extends('layouts.admin') {{-- 1. GUNAKAN LAYOUT ADMIN --}}

@section('title', 'Catat Transaksi Baru')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER HALAMAN --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Catat Transaksi Baru</h1>
        <p class="text-sm text-gray-500">Masukkan detail pemasukan atau pengeluaran anggaran desa.</p>
    </div>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">

            {{-- FORM START --}}
            <form method="POST" action="{{ route('admin.keuangan.store') }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Tanggal --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal Transaksi</label>
                        
                        <input 
                            type="date" 
                            name="tanggal_transaksi" 
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight bg-gray-200 cursor-not-allowed"
                            value="{{ date('Y-m-d') }}" 
                            readonly
                        >                   
                        <p class="text-xs text-red-500 mt-1">*Tanggal otomatis terisi hari ini dan tidak dapat diubah.</p>
                    </div>

                    {{-- Kategori (Input Text Sederhana) --}}
                    <div>
                        <label for="kategori" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <input type="text" id="kategori" name="kategori" value="{{ old('kategori') }}" required
                            placeholder="Contoh: Dana Desa / PADes / Belanja Modal"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                        @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jenis Transaksi --}}
                    <div>
                        <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Jenis Transaksi</label>
                        <select id="jenis" name="jenis" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                            <option value="">-- Pilih Jenis --</option>
                            <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan (Uang Masuk)</option>
                            <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran (Uang Keluar)</option>
                        </select>
                        @error('jenis') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Jumlah / Nominal --}}
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-700 mb-1">Jumlah (Rp)</label>
                        <input type="number" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" required min="0"
                            placeholder="Contoh: 1500000"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                        @error('jumlah') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Keterangan (Full Width) --}}
                    <div class="md:col-span-2">
                        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan / Uraian</label>
                        <textarea id="keterangan" name="keterangan" rows="3" required
                            placeholder="Jelaskan detail transaksi ini..."
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">{{ old('keterangan') }}</textarea>
                        @error('keterangan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex items-center justify-end mt-8 border-t pt-6 space-x-4">
                    {{-- Tombol Batal --}}
                    <a href="{{ route('admin.keuangan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-semibold">
                        Batal
                    </a>
                    
                    {{-- Tombol Simpan --}}
                    <button type="submit" class="px-6 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition text-sm font-semibold shadow-md flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Simpan Transaksi
                    </button>
                </div>

            </form>
            {{-- FORM END --}}

        </div>
    </div>
</div>
@endsection