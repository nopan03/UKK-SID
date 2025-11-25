@extends('layouts.app') 

@section('title', 'Lapor Keluhan')

@section('content')
    
    {{-- A. BAGIAN JUDUL (HEADER) --}}
    {{-- REVISI: 
         - Menghapus bg-green-50 (background hijau hilang).
         - Mengubah margin menjadi 'mt-10 mb-4' agar dekat dengan form di bawahnya. 
    --}}
    <div class="container mx-auto px-4 text-center mt-10 mb-4">
        <h1 class="text-3xl md:text-4xl font-bold text-green-800 mb-2">Layanan Pengaduan Warga</h1>
        <p class="text-lg text-gray-600 max-w-2xl mx-auto font-medium">
            Sampaikan aspirasi, keluhan, atau saran Anda demi kemajuan Desa Suruh.
        </p>
    </div>

    {{-- B. CONTAINER FORM --}}
    {{-- REVISI: Mengubah py-10 menjadi pb-10 pt-2 (padding atas dikecilkan agar naik ke atas) --}}
    <div class="container mx-auto px-4 pb-10 pt-2">
        <div class="max-w-3xl mx-auto">
            
            {{-- Card Form --}}
            <div class="bg-white rounded-xl shadow-lg border-t-4 border-yellow-400 overflow-hidden">
                
                <div class="p-8">
                    {{-- Alert Sukses --}}
                    @if(session('success'))
                        <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700 border border-green-200 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Alert Error --}}
                    @if($errors->any())
                        <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- FORMULIR START --}}
                    <form action="{{ route('keluhan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        {{-- Input: Nama Pelapor --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pelapor</label>
                            <input type="text" name="nama_pelapor" 
                                   class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200"
                                   placeholder="Masukkan nama lengkap Anda" required>
                        </div>

                        {{-- Input: Judul Laporan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Judul Laporan</label>
                            <input type="text" name="judul_laporan" 
                                   class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200"
                                   placeholder="Contoh: Lampu Jalan Mati di RT 02" required>
                        </div>

                        {{-- Input: Isi Laporan --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Isi Keluhan / Aspirasi</label>
                            <textarea name="isi_laporan" rows="5" 
                                      class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200"
                                      placeholder="Jelaskan detail permasalahan secara lengkap..." required></textarea>
                        </div>

                        {{-- Input: Foto Bukti --}}
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Bukti (Opsional)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 justify-center">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none">
                                            <span>Upload file gambar</span>
                                            <input id="file-upload" name="foto_bukti" type="file" class="sr-only" accept="image/*" onchange="previewImage()">
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (Maks. 2MB)</p>
                                    {{-- Preview Nama File --}}
                                    <p id="file-name" class="text-sm text-green-600 mt-2 font-semibold"></p>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Kirim --}}
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-green-700 hover:bg-green-800 text-white font-bold py-3 px-4 rounded-lg shadow transition duration-200 flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Laporan
                            </button>
                        </div>

                    </form>
                    {{-- FORMULIR END --}}
                </div>
            </div>

            {{-- Informasi Tambahan --}}
            <div class="text-center mt-6 text-gray-500 text-sm">
                <p>Identitas pelapor akan dijaga kerahasiaannya oleh pemerintah desa.</p>
            </div>

        </div>
    </div>

    {{-- Script Sederhana untuk Menampilkan Nama File saat Upload --}}
    <script>
        function previewImage() {
            const input = document.getElementById('file-upload');
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileNameDisplay.textContent = "File terpilih: " + input.files[0].name;
            } else {
                fileNameDisplay.textContent = "";
            }
        }
    </script>
@endsection