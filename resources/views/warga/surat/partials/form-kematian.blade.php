<div class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Almarhum <span class="text-red-500">*</span></label>
            <input type="text" name="nama_almarhum" required class="w-full border-gray-300 rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Meninggal <span class="text-red-500">*</span></label>
            <input type="date" name="tgl_meninggal" required class="w-full border-gray-300 rounded-lg">
        </div>
    </div>

    {{-- Upload Dokumen --}}
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
        <h4 class="font-semibold text-gray-700 text-sm border-b pb-2">Dokumen Pendukung</h4>

        {{-- Surat Kematian RS --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Surat Keterangan Kematian (RS/Dokter)</label>
            <input type="file" name="file_ket_kematian" accept=".jpg,.jpeg,.png,.pdf" 
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 border border-gray-300 rounded-lg">
            <p class="text-xs text-gray-500 mt-1">Jika meninggal di Rumah Sakit.</p>
        </div>

        {{-- KTP Almarhum --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">KTP Almarhum <span class="text-red-500">*</span></label>
            <input type="file" name="file_ktp_almarhum" required accept=".jpg,.jpeg,.png,.pdf" 
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 border border-gray-300 rounded-lg">
        </div>

        {{-- KK Almarhum --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">KK Almarhum <span class="text-red-500">*</span></label>
            <input type="file" name="file_kk_almarhum" required accept=".jpg,.jpeg,.png,.pdf" 
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 border border-gray-300 rounded-lg">
        </div>
    </div>
</div>