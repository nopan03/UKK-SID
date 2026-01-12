<div class="space-y-6">

    {{-- Field "Keperluan" DIHAPUS.
        Keperluan pembuatan SKCK sekarang memakai textarea utama name="keperluan". --}}

    {{-- Upload Dokumen --}}
    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 space-y-4">
        <h4 class="font-semibold text-gray-700 text-sm border-b pb-2">
            Dokumen Pendukung (Wajib)
        </h4>

        {{-- KTP --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Foto KTP <span class="text-red-500">*</span>
            </label>
            <input type="file" name="file_ktp" required
                accept=".jpg,.jpeg,.png,.pdf"
                class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-green-100 file:text-green-700
                       hover:file:bg-blue-100 border border-gray-300 rounded-lg">
        </div>

        {{-- KK --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Foto Kartu Keluarga (KK) <span class="text-red-500">*</span>
            </label>
            <input type="file" name="file_kk" required
                accept=".jpg,.jpeg,.png,.pdf"
                class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-green-100 file:text-green-700
                       hover:file:bg-blue-100 border border-gray-300 rounded-lg">
        </div>

        {{-- Akta Kelahiran --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Foto Akta Kelahiran <span class="text-red-500">*</span>
            </label>
            <input type="file" name="file_akta" required
                accept=".jpg,.jpeg,.png,.pdf"
                class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-green-100 file:text-green-700
                       hover:file:bg-blue-100 border border-gray-300 rounded-lg">
        </div>

        {{-- Pengantar RT --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Surat Pengantar RT/RW <span class="text-red-500">*</span>
            </label>
            <input type="file" name="file_pengantar" required
                accept=".jpg,.jpeg,.png,.pdf"
                class="block w-full text-sm text-gray-500
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-green-100 file:text-green-700
                       hover:file:bg-blue-100 border border-gray-300 rounded-lg">
        </div>
    </div>
</div>
