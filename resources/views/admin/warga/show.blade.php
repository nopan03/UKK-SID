<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Data Warga: ') . $warga->nama }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    
                    {{-- Menggunakan grid untuk tata letak 2 kolom --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        
                        <div>
                            <p class="text-sm text-gray-500">NIK</p>
                            <p class="font-semibold text-lg">{{ $warga->nik }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Nama Lengkap</p>
                            <p class="font-semibold text-lg">{{ $warga->nama }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Tempat, Tanggal Lahir</p>
                            <p class="font-semibold">{{ $warga->tempat_lahir }}, {{ \Carbon\Carbon::parse($warga->tanggal_lahir)->format('d F Y') }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Jenis Kelamin</p>
                            <p class="font-semibold">{{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>

                        {{-- INI BAGIAN YANG DIPERBAIKI --}}
                        <div>
                            <p class="text-sm text-gray-500">Agama</p>
                            <p class="font-semibold">{{ $warga->agama }}</p>
                        </div>
                         
                         <div>
                            <p class="text-sm text-gray-500">Status Perkawinan</p>
                            <p class="font-semibold">{{ $warga->status_perkawinan }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Pekerjaan</p>
                            <p class="font-semibold">{{ $warga->pekerjaan }}</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">Status Hidup</p>
                            <p class="font-semibold capitalize">{{ $warga->status_hidup }}</p>
                        </div>

                         <div class="md:col-span-2">
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="font-semibold">{{ $warga->alamat }}</p>
                        </div>
                    </div>

                    {{-- Tombol Kembali --}}
                    <div class="flex items-center justify-end mt-8 border-t pt-6">
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                            Kembali ke Dashboard
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>