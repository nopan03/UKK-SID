<div class="space-y-6">

    {{-- Detail Tanah --}}
    {{-- Wrapper border & background dihapus agar langsung menyatu dengan halaman --}}
    <div class="grid grid-cols-1 gap-6">
        {{-- Luas Tanah --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Luas Tanah (m²) <span class="text-red-500">*</span></label>
            <input type="number" name="luas_tanah" required placeholder="Contoh: 150" value="{{ old('luas_tanah') }}" min="1"
                class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">
        </div>

        {{-- Lokasi Tanah --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Tanah Lengkap <span class="text-red-500">*</span></label>
            <textarea name="lokasi_tanah" rows="2" required placeholder="Contoh: Blok A, Dusun Krajan, RT 02 RW 01 (Sebelah sawah Bpk. Joyo)"
                class="w-full border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500 transition duration-200 shadow-sm">{{ old('lokasi_tanah') }}</textarea>
        </div>
    </div>

    {{-- Upload Dokumen --}}
    <div class="bg-gray-50 p-5 rounded-xl border border-gray-200 space-y-4">
        <h4 class="font-bold text-gray-800 text-sm border-b border-gray-200 pb-2 mb-2">Dokumen Pendukung (Wajib)</h4>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- KTP --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto KTP Pemilik <span class="text-red-500">*</span></label>
                <input type="file" name="file_ktp" required accept=".jpg,.jpeg,.png,.pdf" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-lg cursor-pointer">
            </div>

            {{-- KK --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto KK Pemilik <span class="text-red-500">*</span></label>
                <input type="file" name="file_kk" required accept=".jpg,.jpeg,.png,.pdf" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-lg cursor-pointer">
            </div>

            {{-- Bukti Tanah --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Kepemilikan (Letter C / Girik / Akta) <span class="text-red-500">*</span></label>
                <input type="file" name="file_bukti_tanah" required accept=".jpg,.jpeg,.png,.pdf" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-lg cursor-pointer">
            </div>

            {{-- SPPT PBB --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">SPPT PBB Terakhir <span class="text-red-500">*</span></label>
                <input type="file" name="file_pbb" required accept=".jpg,.jpeg,.png,.pdf" 
                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 border border-gray-300 rounded-lg cursor-pointer">
            </div>
        </div>

        <div class="mt-2 flex items-center gap-2 text-xs text-gray-500 bg-white p-2 rounded border border-gray-100">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <p>Pastikan dokumen terlihat jelas dan tidak terpotong. Format: JPG, PNG, atau PDF. Maksimal 2MB.</p>
        </div>
    </div>

</div>