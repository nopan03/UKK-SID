<x-app-layout>
    <x-slot name="header">
        {{-- 1. UBAH JUDUL HALAMAN --}}
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Warga: ') . $warga->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- 2. UBAH ACTION FORM & TAMBAHKAN METHOD PUT --}}
                    <form method="POST" action="{{ route('admin.warga.update', $warga->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            {{-- 3. UBAH SEMUA NILAI 'VALUE' AGAR MENAMPILKAN DATA LAMA --}}

                            {{-- Kolom NIK --}}
                            <div>
                                <x-input-label for="nik" :value="__('Nomor Induk Kependudukan (NIK)')" />
                                <x-text-input id="nik" class="block mt-1 w-full" type="text" name="nik" :value="old('nik', $warga->nik)" required autofocus />
                                <x-input-error :messages="$errors->get('nik')" class="mt-2" />
                            </div>

                            {{-- Kolom Nama --}}
                            <div>
                                <x-input-label for="nama" :value="__('Nama Lengkap')" />
                                <x-text-input id="nama" class="block mt-1 w-full" type="text" name="nama" :value="old('nama', $warga->nama)" required />
                                <x-input-error :messages="$errors->get('nama')" class="mt-2" />
                            </div>

                            {{-- Kolom Tempat Lahir --}}
                            <div>
                                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                                <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $warga->tempat_lahir)" required />
                                <x-input-error :messages="$errors->get('tempat_lahir')" class="mt-2" />
                            </div>

                            {{-- Kolom Tanggal Lahir --}}
                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $warga->tanggal_lahir)" required />
                                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
                            </div>

                            {{-- Kolom Jenis Kelamin --}}
                            <div>
                                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                                <select id="jenis_kelamin" name="jenis_kelamin" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="L" @selected(old('jenis_kelamin', $warga->jenis_kelamin) == 'L')>Laki-laki</option>
                                    <option value="P" @selected(old('jenis_kelamin', $warga->jenis_kelamin) == 'P')>Perempuan</option>
                                </select>
                                <x-input-error :messages="$errors->get('jenis_kelamin')" class="mt-2" />
                            </div>

                            {{-- Kolom Agama --}}
                            <div>
                                <x-input-label for="agama" :value="__('Agama')" />
                                <x-text-input id="agama" class="block mt-1 w-full" type="text" name="agama" :value="old('agama', $warga->agama)" required />
                                <x-input-error :messages="$errors->get('agama')" class="mt-2" />
                            </div>
                            
                            {{-- Kolom Status Perkawinan --}}
                             <div>
                                <x-input-label for="status_perkawinan" :value="__('Status Perkawinan')" />
                                <select id="status_perkawinan" name="status_perkawinan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="Belum Kawin" @selected(old('status_perkawinan', $warga->status_perkawinan) == 'Belum Kawin')>Belum Kawin</option>
                                    <option value="Kawin" @selected(old('status_perkawinan', $warga->status_perkawinan) == 'Kawin')>Kawin</option>
                                    <option value="Cerai Hidup" @selected(old('status_perkawinan', $warga->status_perkawinan) == 'Cerai Hidup')>Cerai Hidup</option>
                                    <option value="Cerai Mati" @selected(old('status_perkawinan', $warga->status_perkawinan) == 'Cerai Mati')>Cerai Mati</option>
                                </select>
                                <x-input-error :messages="$errors->get('status_perkawinan')" class="mt-2" />
                            </div>

                            {{-- Kolom Pekerjaan --}}
                            <div>
                                <x-input-label for="pekerjaan" :value="__('Pekerjaan')" />
                                <x-text-input id="pekerjaan" class="block mt-1 w-full" type="text" name="pekerjaan" :value="old('pekerjaan', $warga->pekerjaan)" required />
                                <x-input-error :messages="$errors->get('pekerjaan')" class="mt-2" />
                            </div>

                             {{-- Kolom Status Hidup --}}
                            <div class="md:col-span-2">
                                <x-input-label for="status_hidup" :value="__('Status Hidup')" />
                                <select id="status_hidup" name="status_hidup" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="hidup" @selected(old('status_hidup', $warga->status_hidup) == 'hidup')>Hidup</option>
                                    <option value="meninggal" @selected(old('status_hidup', $warga->status_hidup) == 'meninggal')>Meninggal</option>
                                </select>
                                <x-input-error :messages="$errors->get('status_hidup')" class="mt-2" />
                            </div>

                            {{-- Kolom Alamat --}}
                            <div class="md:col-span-2">
                                <x-input-label for="alamat" :value="__('Alamat')" />
                                <textarea id="alamat" name="alamat" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('alamat', $warga->alamat) }}</textarea>
                                <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">
                                Batal
                            </a>
                            <x-primary-button>
                                {{-- Ubah Teks Tombol --}}
                                {{ __('Perbarui Data Warga') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>