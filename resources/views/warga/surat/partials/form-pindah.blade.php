
{{-- resources/views/warga/surat/partials/form-pindah.blade.php --}}

<h4 class="text-base font-semibold text-gray-800 mb-4">
    Data Kepindahan
</h4>

<div class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Alamat Asal --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Alamat Asal <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="alamat_asal"
                value="{{ old('alamat_asal') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                placeholder="Masukkan alamat asal sebelum pindah"
                required>
        </div>

        {{-- Alamat Tujuan --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Alamat Tujuan Pindah <span class="text-red-500">*</span>
            </label>
            <input
                type="text"
                name="alamat_tujuan"
                value="{{ old('alamat_tujuan') }}"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
                placeholder="Masukkan alamat tujuan pindah"
                required>
        </div>
    </div>

    {{-- Alasan Pindah --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Alasan Pindah <span class="text-red-500">*</span>
        </label>
        <textarea
            name="alasan_pindah"
            rows="3"
            required
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
            placeholder="Jelaskan alasan pindah...">{{ old('alasan_pindah') }}</textarea>
    </div>

    {{-- Jumlah Anggota --}}
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">
            Jumlah Anggota Keluarga yang Ikut Pindah <span class="text-red-500">*</span>
        </label>
        <input
            type="number"
            min="1"
            name="jumlah_pindah"
            value="{{ old('jumlah_pindah') }}"
            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"
            placeholder="Contoh: 3"
            required>
    </div>

</div>

{{-- ==== DOKUMEN ==== --}}
<div class="mt-8 bg-gray-50 p-4 rounded-lg border border-gray-200">
    <h4 class="text-base font-semibold text-gray-800 mb-4">
        Dokumen Pendukung
    </h4>

    <div class="space-y-4">
        {{-- Upload KTP --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Upload KTP</label>
            <input
                type="file"
                name="file_ktp"
                accept=".jpg,.jpeg,.png,.pdf"
                class="block w-full text-sm text-gray-700
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-green-100 file:text-green-700
                       hover:file:bg-green-200 border border-gray-300 rounded-lg">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG atau PDF. Maks 2MB.</p>
        </div>

        {{-- Upload KK --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Upload KK</label>
            <input
                type="file"
                name="file_kk"
                accept=".jpg,.jpeg,.png,.pdf"
                class="block w-full text-sm text-gray-700
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-green-100 file:text-green-700
                       hover:file:bg-green-200 border border-gray-300 rounded-lg">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG atau PDF. Maks 2MB.</p>
        </div>

        {{-- Pengantar RT/RW --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Surat Pengantar RT/RW</label>
            <input
                type="file"
                name="file_pengantar"
                accept=".jpg,.jpeg,.png,.pdf"
                class="block w-full text-sm text-gray-700
                       file:mr-4 file:py-2 file:px-4
                       file:rounded-full file:border-0
                       file:text-sm file:font-semibold
                       file:bg-green-100 file:text-green-700
                       hover:file:bg-green-200 border border-gray-300 rounded-lg">
            <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG atau PDF. Maks 2MB.</p>
        </div>
    </div>
</div>