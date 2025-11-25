@extends('layouts.admin') {{-- 1. GUNAKAN LAYOUT ADMIN --}}

@section('title', 'Tambah Data Warga Baru')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER HALAMAN --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Warga Baru</h1>
        <p class="text-sm text-gray-500">Masukkan data penduduk baru secara lengkap dan benar.</p>
    </div>

    {{-- CARD FORM --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8">
            
            {{-- FORM START --}}
            <form method="POST" action="{{ route('admin.warga.store') }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    {{-- Kolom NIK --}}
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Kependudukan (NIK)</label>
                        <input type="text" id="nik" name="nik" value="{{ old('nik') }}" required autofocus
                            placeholder="Contoh: 3515xxxxxxxxxxxx"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kolom Nama --}}
                    <div>
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                            placeholder="Sesuai KTP"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                        @error('nama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kolom Tempat Lahir --}}
                    <div>
                        <label for="tempat_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" value="{{ old('tempat_lahir') }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                        @error('tempat_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kolom Tanggal Lahir --}}
                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                        <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                        @error('tanggal_lahir') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kolom Jenis Kelamin --}}
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kolom Agama --}}
                    <div>
                        <label for="agama" class="block text-sm font-medium text-gray-700 mb-1">Agama</label>
                        <select id="agama" name="agama" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen Protestan" {{ old('agama') == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                            <option value="Kristen Katolik" {{ old('agama') == 'Kristen Katolik' ? 'selected' : '' }}>Kristen Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Khonghucu" {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                        </select>
                        @error('agama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kolom Status Perkawinan --}}
                    <div>
                        <label for="status_perkawinan" class="block text-sm font-medium text-gray-700 mb-1">Status Perkawinan</label>
                        <select id="status_perkawinan" name="status_perkawinan" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                    </div>

                    {{-- Kolom Pekerjaan --}}
                    <div>
                        <label for="pekerjaan" class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan</label>
                        <input type="text" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}" required
                            placeholder="Contoh: Petani / Wiraswasta"
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                        @error('pekerjaan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Kolom Status Hidup --}}
                    <div class="md:col-span-2">
                        <label for="status_hidup" class="block text-sm font-medium text-gray-700 mb-1">Status Hidup</label>
                        <select id="status_hidup" name="status_hidup" class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200">
                            <option value="hidup" {{ old('status_hidup') == 'hidup' ? 'selected' : '' }}>Hidup</option>
                            <option value="meninggal" {{ old('status_hidup') == 'meninggal' ? 'selected' : '' }}>Meninggal</option>
                        </select>
                    </div>

                    {{-- Kolom Alamat --}}
                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                        <textarea id="alamat" name="alamat" rows="3" required
                            class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200"
                            placeholder="Nama Jalan, RT/RW, Dusun">{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                </div>

                {{-- TOMBOL AKSI --}}
                <div class="flex items-center justify-end mt-8 border-t pt-6 space-x-4">
                    {{-- 2. UBAH LINK BATAL: Arahkan ke Index Warga, bukan Dashboard --}}
                    <a href="{{ route('admin.warga.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm font-semibold">
                        Batal
                    </a>
                    
                    <button type="submit" class="px-6 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition text-sm font-semibold shadow-md flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Simpan Data Warga
                    </button>
                </div>

            </form>
            {{-- FORM END --}}
            
        </div>
    </div>
</div>
@endsection