<div class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Bayi <span class="text-red-500">*</span></label>
            <input type="text" name="nama_bayi" required class="w-full border-gray-300 rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
            <input type="date" name="tgl_lahir_bayi" required class="w-full border-gray-300 rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ayah <span class="text-red-500">*</span></label>
            <input type="text" name="nama_ayah" required class="w-full border-gray-300 rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Ibu <span class="text-red-500">*</span></label>
            <input type="text" name="nama_ibu" required class="w-full border-gray-300 rounded-lg">
        </div>
    </div>

    {{-- Upload Dokumen --}}
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
        <h4 class="font-semibold text-gray-700 text-sm border-b pb-2">Dokumen Pendukung</h4>

        {{-- Surat Bidan/RS --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Surat Keterangan Lahir (Bidan/RS) <span class="text-red-500">*</span></label>
            <input type="file" name="file_ket_lahir" required accept=".jpg,.jpeg,.png,.pdf" 
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 border border-gray-300 rounded-lg">
        </div>

        {{-- KK --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Kartu Keluarga (KK) <span class="text-red-500">*</span></label>
            <input type="file" name="file_kk" required accept=".jpg,.jpeg,.png,.pdf" 
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 border border-gray-300 rounded-lg">
        </div>

        {{-- Buku Nikah --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto Buku Nikah Orang Tua <span class="text-red-500">*</span></label>
            <input type="file" name="file_buku_nikah" required accept=".jpg,.jpeg,.png,.pdf" 
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pink-50 file:text-pink-700 hover:file:bg-pink-100 border border-gray-300 rounded-lg">
        </div>
    </div>
</div>