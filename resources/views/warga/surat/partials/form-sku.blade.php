<div class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha <span class="text-red-500">*</span></label>
            <input type="text" name="nama_usaha" required class="w-full border-gray-300 rounded-lg focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Usaha <span class="text-red-500">*</span></label>
            <input type="text" name="jenis_usaha" required class="w-full border-gray-300 rounded-lg focus:ring-green-500">
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Usaha <span class="text-red-500">*</span></label>
        <textarea name="alamat_usaha" rows="2" required class="w-full border-gray-300 rounded-lg focus:ring-green-500"></textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan <span class="text-red-500">*</span></label>
        <textarea name="keperluan" rows="2" required class="w-full border-gray-300 rounded-lg focus:ring-green-500"></textarea>
    </div>

    {{-- Upload Dokumen --}}
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
        <h4 class="font-semibold text-gray-700 text-sm border-b pb-2">Dokumen Pendukung</h4>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto KTP <span class="text-red-500">*</span></label>
            <input type="file" name="file_ktp" required accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Usaha (Foto Tempat/Produk)</label>
            <input type="file" name="file_bukti_usaha" accept=".jpg,.jpeg,.png" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 border border-gray-300 rounded-lg">
        </div>
    </div>
</div>