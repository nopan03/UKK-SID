<div class="space-y-6">
    
    {{-- Keperluan --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Keperluan <span class="text-red-500">*</span></label>
        <textarea name="keperluan" rows="3" required class="w-full border-gray-300 rounded-lg focus:ring-green-500">{{ old('keperluan') }}</textarea>
    </div>

    {{-- Data Tambahan --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Penghasilan (Rp)</label>
            <input type="number" name="penghasilan" class="w-full border-gray-300 rounded-lg focus:ring-green-500">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Jml Tanggungan</label>
            <input type="number" name="tanggungan" class="w-full border-gray-300 rounded-lg focus:ring-green-500">
        </div>
    </div>

    {{-- Upload Dokumen --}}
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
        <h4 class="font-semibold text-gray-700 text-sm border-b pb-2">Dokumen Pendukung (Wajib)</h4>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto KTP <span class="text-red-500">*</span></label>
            <input type="file" name="file_ktp" required accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Foto KK <span class="text-red-500">*</span></label>
            <input type="file" name="file_kk" required accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Surat Pengantar RT <span class="text-red-500">*</span></label>
            <input type="file" name="file_pengantar" required accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-100 file:text-green-700 hover:file:bg-green-200 border border-gray-300 rounded-lg">
        </div>
    </div>
</div>