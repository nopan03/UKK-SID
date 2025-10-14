<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tulis Berita Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">

                    {{-- enctype="multipart/form-data" WAJIB untuk form yang ada upload file --}}
                    <form method="POST" action="{{ route('admin.berita.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            {{-- Judul --}}
                            <div>
                                <x-input-label for="judul" :value="__('Judul Berita')" />
                                <x-text-input id="judul" class="block mt-1 w-full" type="text" name="judul"
                                    :value="old('judul')" required autofocus />
                                <x-input-error :messages="$errors->get('judul')" class="mt-2" />
                            </div>

                            {{-- Kategori & Tanggal --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="kategori" :value="__('Kategori')" />
                                    <x-text-input id="kategori" class="block mt-1 w-full" type="text"
                                        name="kategori" :value="old('kategori')" required />
                                    <x-input-error :messages="$errors->get('kategori')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="tanggal" :value="__('Tanggal Publikasi')" />
                                    <x-text-input id="tanggal" class="block mt-1 w-full" type="date" name="tanggal"
                                        :value="old('tanggal')" required />
                                    <x-input-error :messages="$errors->get('tanggal')" class="mt-2" />
                                </div>
                            </div>

                            {{-- Upload Gambar --}}
                            <div>
                                <x-input-label for="gambar" :value="__('Gambar Utama (Opsional)')" />
                                <input id="gambar"
                                    class="block mt-1 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                    type="file" name="gambar">
                                <p class="mt-1 text-sm text-gray-500">Tipe file: JPG, PNG, GIF. Maksimal 2MB.</p>

                                {{-- PASTIKAN BARIS INI ADA --}}
                                <x-input-error :messages="$errors->get('gambar')" class="mt-2" />
                            </div>

                            {{-- Isi Berita --}}
                            <div>
                                <x-input-label for="isi" :value="__('Isi Berita')" />
                                <textarea id="isi" name="isi" rows="10"
                                    class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('isi') }}</textarea>
                                <x-input-error :messages="$errors->get('isi')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.berita.index') }}"
                                class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan Berita') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
