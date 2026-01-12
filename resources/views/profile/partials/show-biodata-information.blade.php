<div class="bg-white p-6 md:p-8 rounded-xl shadow-md border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-1">Biodata Warga</h3>
    <p class="text-sm text-gray-500 mb-6">
        Data biodata diambil dari sistem kependudukan desa.
    </p>

    @php
        $bio = $user->penduduk;  // relasi ke tabel penduduk/biodata
    @endphp

    @if($bio)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">NIK</p>
                <p class="font-semibold text-gray-800">{{ $bio->nik }}</p>
            </div>
            <div>
                <p class="text-gray-500">Nama Lengkap</p>
                <p class="font-semibold text-gray-800">{{ $bio->nama_lengkap }}</p>
            </div>
            <div>
                <p class="text-gray-500">Tempat, Tanggal Lahir</p>
                <p class="font-semibold text-gray-800">
                    {{ $bio->tempat_lahir }}, {{ \Carbon\Carbon::parse($bio->tanggal_lahir)->format('d M Y') }}
                </p>
            </div>
            <div>
                <p class="text-gray-500">Jenis Kelamin</p>
                <p class="font-semibold text-gray-800">{{ $bio->jenis_kelamin }}</p>
            </div>
            <div>
                <p class="text-gray-500">Alamat</p>
                <p class="font-semibold text-gray-800">
                    {{ $bio->alamat }}, RT {{ $bio->rt }}/RW {{ $bio->rw }}
                </p>
            </div>
            <div>
                <p class="text-gray-500">Pekerjaan</p>
                <p class="font-semibold text-gray-800">{{ $bio->pekerjaan }}</p>
            </div>
            {{-- tambah field lain sesuai kolom tabelmu --}}
        </div>
    @else
        <p class="text-sm text-gray-500">
            Biodata belum tersedia. Silakan hubungi admin desa untuk mengisi data kependudukan Anda.
        </p>
    @endif
</div>
