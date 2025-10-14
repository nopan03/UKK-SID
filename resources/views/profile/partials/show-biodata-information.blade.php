<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Biodata Kependudukan') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Informasi detail Anda sesuai dengan data kependudukan yang tercatat.") }}
        </p>
    </header>

    @if (Auth::user()->biodata)
        <div class="mt-6 space-y-4">
            {{-- Data yang sudah ada sebelumnya --}}
            <div>
                <x-input-label for="nama" :value="__('Nama Lengkap')" />
                <x-text-input id="nama" type="text" class="mt-1 block w-full bg-gray-100" :value="Auth::user()->biodata->nama" disabled />
            </div>

            <div>
                <x-input-label for="nik" :value="__('Nomor Induk Kependudukan (NIK)')" />
                <x-text-input id="nik" type="text" class="mt-1 block w-full bg-gray-100" :value="Auth::user()->biodata->nik" disabled />
            </div>

            <div>
                <x-input-label for="ttl" :value="__('Tempat, Tanggal Lahir')" />
                <x-text-input id="ttl" type="text" class="mt-1 block w-full bg-gray-100" 
                    :value="Auth::user()->biodata->tempat_lahir . ', ' . \Carbon\Carbon::parse(Auth::user()->biodata->tanggal_lahir)->format('d F Y')" disabled />
            </div>

            {{-- ======================================================= --}}
            {{-- DATA TAMBAHAN SESUAI PERMINTAAN ANDA --}}
            {{-- ======================================================= --}}

            <div>
                <x-input-label for="jenis_kelamin" :value="__('Jenis Kelamin')" />
                <x-text-input id="jenis_kelamin" type="text" class="mt-1 block w-full bg-gray-100" 
                    :value="Auth::user()->biodata->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'" disabled />
            </div>

            <div>
                <x-input-label for="agama" :value="__('Agama')" />
                <x-text-input id="agama" type="text" class="mt-1 block w-full bg-gray-100" :value="Auth::user()->biodata->agama" disabled />
            </div>
            
            <div>
                <x-input-label for="pendidikan" :value="__('Pendidikan Terakhir')" />
                <x-text-input id="pendidikan" type="text" class="mt-1 block w-full bg-gray-100" :value="Auth::user()->biodata->pendidikan" disabled />
            </div>

            <div>
                <x-input-label for="status_perkawinan" :value="__('Status Perkawinan')" />
                <x-text-input id="status_perkawinan" type="text" class="mt-1 block w-full bg-gray-100" :value="Auth::user()->biodata->status_perkawinan" disabled />
            </div>
            
            <div>
                <x-input-label for="pekerjaan" :value="__('Pekerjaan')" />
                <x-text-input id="pekerjaan" type="text" class="mt-1 block w-full bg-gray-100" :value="Auth::user()->biodata->pekerjaan" disabled />
            </div>

            <div>
                <x-input-label for="alamat" :value="__('Alamat')" />
                <textarea id="alamat" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" disabled>{{ Auth::user()->biodata->alamat }}</textarea>
            </div>

            <div>
                <x-input-label for="status_hidup" :value="__('Status Hidup')" />
                <x-text-input id="status_hidup" type="text" class="mt-1 block w-full bg-gray-100" :value="ucfirst(Auth::user()->biodata->status_hidup)" disabled />
            </div>

        </div>
    @else
        <p class="mt-4 text-sm text-red-600">
            Data biodata tidak ditemukan untuk pengguna ini.
        </p>
    @endif
</section>