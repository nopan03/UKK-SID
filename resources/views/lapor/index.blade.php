<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
            {{-- Ikon Header tetap ada sebagai identitas halaman --}}
            <i class="ti ti-user-plus text-yellow-500"></i>
            {{ __('Layanan Lapor Diri') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            {{-- ALERT SUKSES --}}
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex items-start gap-3" role="alert">
                    <i class="ti ti-circle-check text-xl mt-0.5"></i>
                    <div>
                        <p class="font-bold">Berhasil!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- ========================================== --}}
            {{-- LOGIKA STATUS LAPORAN --}}
            {{-- ========================================== --}}

            @if($riwayat && $riwayat->status == 'menunggu')
                
                {{-- CARD STATUS: MENUNGGU --}}
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border-t-4 border-yellow-400 p-8 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 text-yellow-500 rounded-full mb-6 animate-pulse">
                        <i class="ti ti-clock-hour-4 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Laporan Sedang Diproses</h3>
                    <p class="text-gray-500 max-w-lg mx-auto">
                        Terima kasih, <strong>{{ Auth::user()->name }}</strong>. Data Anda sudah kami terima dan sedang dalam antrean verifikasi oleh Admin Desa. Mohon cek berkala dalam 1x24 jam.
                    </p>
                    <div class="mt-8">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800">
                            Status: Menunggu Verifikasi
                        </span>
                    </div>
                </div>

            @elseif($riwayat && $riwayat->status == 'disetujui')

                {{-- CARD STATUS: DISETUJUI --}}
                <div class="bg-white overflow-hidden shadow-lg sm:rounded-2xl border-t-4 border-green-500 p-8 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 bg-green-100 text-green-600 rounded-full mb-6">
                        <i class="ti ti-confetti text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Selamat! Anda Telah Terverifikasi</h3>
                    <p class="text-gray-500 max-w-lg mx-auto mb-8">
                        Anda kini tercatat secara resmi sebagai <strong>Warga Pendatang</strong> di Desa Suruh. Akses layanan surat menyurat kini telah terbuka.
                    </p>
                    <a href="{{ route('surat.index') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-600 hover:bg-green-700 shadow-md transition hover:-translate-y-1">
                        <i class="ti ti-file-text mr-2"></i> Buat Surat Sekarang
                    </a>
                </div>

            @else

                {{-- FORMULIR PENGISIAN --}}
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl">
                    
                    {{-- Header Form --}}
                    <div class="bg-gradient-to-r from-green-700 to-green-600 p-6 sm:p-10 text-white">
                        <h3 class="text-2xl font-bold flex items-center gap-2">
                            <i class="ti ti-clipboard-list"></i> Formulir Data Pendatang
                        </h3>
                        <p class="text-green-100 mt-2 text-sm sm:text-base">
                            Mohon lengkapi data diri Anda sesuai dengan KTP asli untuk keperluan administrasi desa.
                        </p>
                    </div>

                    {{-- Pesan Jika Ditolak --}}
                    @if($riwayat && $riwayat->status == 'ditolak')
                        <div class="mx-6 sm:mx-10 mt-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-start gap-3">
                            <i class="ti ti-alert-circle text-red-500 text-2xl"></i>
                            <div>
                                <h4 class="font-bold text-red-800">Pengajuan Sebelumnya Ditolak</h4>
                                <p class="text-red-600 text-sm mt-1">Alasan: "{{ $riwayat->pesan_admin ?? 'Dokumen kurang jelas' }}"</p>
                                <p class="text-red-600 text-sm font-semibold mt-2">Silakan perbaiki data di bawah ini dan kirim ulang.</p>
                            </div>
                        </div>
                    @endif

                    <div class="p-6 sm:p-10">
                        <form action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                            @csrf

                            {{-- SECTION 1: DATA AKUN (READONLY) --}}
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Identitas Akun</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-xs text-gray-500">Nama Lengkap</label>
                                        <div class="font-semibold text-gray-800">{{ Auth::user()->name }}</div>
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500">NIK</label>
                                        <div class="font-semibold text-gray-800">{{ Auth::user()->nik }}</div>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 2: BIODATA --}}
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                                    <span class="bg-yellow-100 text-yellow-600 w-8 h-8 flex items-center justify-center rounded-full text-sm">1</span>
                                    Biodata Diri
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Tempat Lahir --}}
                                    <div>
                                        <label class="block font-medium text-gray-700 mb-1">Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="Kota Kelahiran" required>
                                        @error('tempat_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Tanggal Lahir (DIBATASI) --}}
                                    <div>
                                        <label class="block font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                                        {{-- 
                                            🔥 PERBAIKAN LOGIKA TANGGAL 🔥
                                            max="{{ date('Y-m-d') }}" -> Mencegah pilih tanggal besok/tahun 3333
                                        --}}
                                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                                               max="{{ date('Y-m-d') }}"
                                               class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                                        @error('tanggal_lahir') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Jenis Kelamin --}}
                                    <div>
                                        <label class="block font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                                            <option value="">- Pilih Jenis Kelamin -</option>
                                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>

                                    {{-- Agama --}}
                                    <div>
                                        <label class="block font-medium text-gray-700 mb-1">Agama</label>
                                        <select name="agama" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" required>
                                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                    </div>

                                    {{-- Status Perkawinan --}}
                                    <div>
                                        <label class="block font-medium text-gray-700 mb-1">Status Perkawinan</label>
                                        <select name="status_perkawinan" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500">
                                            <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                            <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                        </select>
                                    </div>

                                    {{-- Pekerjaan --}}
                                    <div>
                                        <label class="block font-medium text-gray-700 mb-1">Pekerjaan</label>
                                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="Pekerjaan saat ini" required>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 3: DOMISILI & TUJUAN --}}
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                                    <span class="bg-yellow-100 text-yellow-600 w-8 h-8 flex items-center justify-center rounded-full text-sm">2</span>
                                    Alamat & Tujuan
                                </h4>
                                <div class="grid grid-cols-1 gap-6">
                                    {{-- Alamat Asal --}}
                                    <div>
                                        <label class="block font-medium text-gray-700 mb-1">Alamat Asal (Sesuai KTP)</label>
                                        <textarea name="alamat_asal" rows="3" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="Jalan, RT/RW, Desa, Kecamatan, Kabupaten..." required>{{ old('alamat_asal') }}</textarea>
                                        @error('alamat_asal') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Keperluan --}}
                                    <div>
                                        <label class="block font-medium text-gray-700 mb-1">Keperluan Menetap</label>
                                        <input type="text" name="keperluan" value="{{ old('keperluan') }}" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" placeholder="Contoh: Bekerja Proyek Jembatan / Melanjutkan Studi" required>
                                    </div>
                                </div>
                            </div>

                            {{-- SECTION 4: UPLOAD DOKUMEN --}}
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2 border-b pb-2">
                                    <span class="bg-yellow-100 text-yellow-600 w-8 h-8 flex items-center justify-center rounded-full text-sm">3</span>
                                    Dokumen Pendukung
                                </h4>
                                
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                    <label class="block font-bold text-gray-700 mb-2">Upload Foto KTP / Surat Pengantar</label>
                                    
                                    {{-- Area Upload ini kita biarkan ada ikonnya agar user paham ini tempat drag & drop file --}}
                                    <div class="flex items-center justify-center w-full">
                                        <label for="foto-upload" class="flex flex-col items-center justify-center w-full h-40 border-2 border-blue-300 border-dashed rounded-lg cursor-pointer bg-white hover:bg-blue-50 transition">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <i class="ti ti-cloud-upload text-4xl text-blue-400 mb-3"></i>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau seret file ke sini</p>
                                                <p class="text-xs text-gray-500">JPG, PNG (Maks. 2MB)</p>
                                            </div>
                                            <input id="foto-upload" name="foto_surat" type="file" class="hidden" required />
                                        </label>
                                    </div>
                                    <div id="file-name" class="mt-2 text-sm text-gray-600 font-medium hidden">
                                        File terpilih: <span id="file-name-text"></span>
                                    </div>
                                    @error('foto_surat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- TOMBOL SUBMIT --}}
                            <div class="pt-4">
                                <button type="submit" class="w-full flex justify-center items-center gap-2 py-4 px-4 border border-transparent rounded-lg shadow-sm text-lg font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all transform hover:-translate-y-1">
                                    {{-- Ikon Kirim tetap ada agar tombol terlihat sebagai aksi utama --}}
                                    <i class="ti ti-send"></i> Kirim Laporan Diri
                                </button>
                                <p class="text-center text-xs text-gray-400 mt-4">Pastikan data yang Anda isi sudah benar sebelum mengirim.</p>
                            </div>

                        </form>
                    </div>
                </div>

            @endif

        </div>
    </div>

    {{-- Script Sederhana untuk Nama File Upload --}}
    <script>
        const fileInput = document.getElementById('foto-upload');
        const fileNameDiv = document.getElementById('file-name');
        const fileNameText = document.getElementById('file-name-text');

        if(fileInput) {
            fileInput.addEventListener('change', function(){
                if(this.files && this.files.length > 0){
                    fileNameText.textContent = this.files[0].name;
                    fileNameDiv.classList.remove('hidden');
                }
            });
        }
    </script>
</x-app-layout>