<div class="space-y-6">

    {{-- BAGIAN 1: Data Calon Pasangan --}}
    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
        <div class="flex items-center mb-4 border-b border-gray-200 pb-2">
            <svg class="w-5 h-5 text-pink-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
            <h4 class="font-bold text-gray-800 text-sm">Data Calon Pasangan</h4>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama Pasangan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Pasangan <span class="text-red-500">*</span></label>
                <input type="text" name="nama_pasangan" required placeholder="Contoh: Siti Aminah" value="{{ old('nama_pasangan') }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">
            </div>
            
            {{-- NIK Pasangan --}}
            <div>
                <label for="nik_pasangan" class="block text-sm font-medium text-gray-700 mb-1">
                    NIK Pasangan <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nik_pasangan" id="nik_pasangan" inputmode="numeric" 
                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition duration-200"
                    placeholder="Masukkan 16 digit NIK..." value="{{ old('nik_pasangan') }}" required maxlength="16"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)">
                <p class="text-xs text-gray-500 mt-1">Wajib 16 digit angka.</p>
            </div>

            {{-- 🔥 KOLOM BARU: Tempat Lahir --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir Pasangan <span class="text-red-500">*</span></label>
                <input type="text" name="tempat_lahir_pasangan" required placeholder="Contoh: Surabaya" value="{{ old('tempat_lahir_pasangan') }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">
            </div>

            {{-- 🔥 KOLOM BARU: Tanggal Lahir --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir Pasangan <span class="text-red-500">*</span></label>
                
                {{-- Tambahkan min="1900-01-01" dan max="hari ini" --}}
                <input type="date" name="tanggal_lahir_pasangan" required 
                    value="{{ old('tanggal_lahir_pasangan') }}"
                    min="1900-01-01" 
                    max="{{ date('Y-m-d') }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">
                    
                <p class="text-[10px] text-gray-400 mt-1">*Maksimal tahun sekarang</p>
            </div>

            {{-- 🔥 KOLOM BARU: Agama --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Agama Pasangan <span class="text-red-500">*</span></label>
                <select name="agama_pasangan" required class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">
                    <option value="">-- Pilih Agama --</option>
                    <option value="Islam" {{ old('agama_pasangan') == 'Islam' ? 'selected' : '' }}>Islam</option>
                    <option value="Kristen" {{ old('agama_pasangan') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                    <option value="Katolik" {{ old('agama_pasangan') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                    <option value="Hindu" {{ old('agama_pasangan') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                    <option value="Buddha" {{ old('agama_pasangan') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                    <option value="Khonghucu" {{ old('agama_pasangan') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                </select>
            </div>

            {{-- 🔥 KOLOM BARU: Pekerjaan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan Pasangan <span class="text-red-500">*</span></label>
                <input type="text" name="pekerjaan_pasangan" required placeholder="Contoh: Wiraswasta" value="{{ old('pekerjaan_pasangan') }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">
            </div>

            {{-- 🔥 KOLOM BARU: Alamat Lengkap --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap Pasangan (Sesuai KTP) <span class="text-red-500">*</span></label>
                <textarea name="alamat_pasangan" rows="2" required placeholder="Jalan, RT/RW, Desa, Kecamatan..."
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">{{ old('alamat_pasangan') }}</textarea>
            </div>

            {{-- Status Pasangan --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status Pernikahan Pasangan Saat Ini <span class="text-red-500">*</span></label>
                <select name="status_perkawinan_pasangan" class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">
                    <option value="Perjaka" {{ old('status_perkawinan_pasangan') == 'Perjaka' ? 'selected' : '' }}>Perjaka</option>
                    <option value="Perawan" {{ old('status_perkawinan_pasangan') == 'Perawan' ? 'selected' : '' }}>Perawan</option>
                    <option value="Duda" {{ old('status_perkawinan_pasangan') == 'Duda' ? 'selected' : '' }}>Duda</option>
                    <option value="Janda" {{ old('status_perkawinan_pasangan') == 'Janda' ? 'selected' : '' }}>Janda</option>
                </select>
            </div>
        </div>
    </div>

    {{-- 🔥 BAGIAN 2: Detail Rencana Pernikahan (BARU) --}}
    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
        <div class="flex items-center mb-4 border-b border-gray-200 pb-2">
            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <h4 class="font-bold text-gray-800 text-sm">Rencana Pernikahan</h4>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pernikahan <span class="text-red-500">*</span></label>
                
                {{-- Tambahkan max="9999-12-31" agar mentok 4 digit --}}
                <input type="date" name="tanggal_nikah" required 
                    value="{{ old('tanggal_nikah') }}"
                    min="1900-01-01"
                    max="9999-12-31"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Pernikahan <span class="text-red-500">*</span></label>
                <input type="text" name="lokasi_nikah" required placeholder="Contoh: KUA Kec. Sukodono" value="{{ old('lokasi_nikah') }}"
                    class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">
            </div>
        </div>
    </div>

    {{-- BAGIAN 3: Upload Dokumen --}}
    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 space-y-4">
        <h4 class="font-bold text-gray-800 text-sm border-b border-gray-200 pb-2 mb-2">Dokumen Pendukung (Wajib)</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- KTP Pemohon --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto KTP Anda <span class="text-red-500">*</span></label>
                <input type="file" name="file_ktp" required accept=".jpg,.jpeg,.png,.pdf" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-lg cursor-pointer">
            </div>

            {{-- KK Pemohon --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto KK Anda <span class="text-red-500">*</span></label>
                <input type="file" name="file_kk" required accept=".jpg,.jpeg,.png,.pdf" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-lg cursor-pointer">
            </div>

            {{-- Akta Kelahiran --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Akta Kelahiran Anda <span class="text-red-500">*</span></label>
                <input type="file" name="file_akta" required accept=".jpg,.jpeg,.png,.pdf" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-lg cursor-pointer">
            </div>

            {{-- KTP Pasangan --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto KTP Calon Pasangan <span class="text-red-500">*</span></label>
                <input type="file" name="file_ktp_pasangan" required accept=".jpg,.jpeg,.png,.pdf" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-lg cursor-pointer">
            </div>
        </div>
        <div class="mt-2 flex items-center gap-2 text-xs text-gray-500 bg-white p-2 rounded border border-gray-100">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p>Pastikan foto/scan dokumen terlihat jelas, tidak buram, dan terbaca. Format: JPG, PNG, atau PDF. Maksimal 2MB.</p>
        </div>
    </div>

</div>