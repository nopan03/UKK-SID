<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Warga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Pesan Selamat Datang --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium">Selamat Datang, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600">Ini adalah halaman layanan mandiri Anda. Gunakan menu di bawah untuk mengakses layanan desa.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Kolom Kiri: Ringkasan Biodata --}}
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Biodata Anda</h3>
                            @if(Auth::user()->biodata)
                            <div class="space-y-3">
                                <p><strong class="font-medium text-gray-800">NIK:</strong> {{ Auth::user()->biodata->nik }}</p>
                                <p><strong class="font-medium text-gray-800">Nama Lengkap:</strong> {{ Auth::user()->biodata->nama }}</p>
                                <p><strong class="font-medium text-gray-800">Alamat:</strong> {{ Auth::user()->biodata->alamat }}</p>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('profile.edit') }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                                    Lihat & Lengkapi Profil &rarr;
                                a>
                            </div>
                            @else
                            <p class="text-sm text-red-600">Data biodata Anda tidak ditemukan. Silakan hubungi perangkat desa.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Aksi Cepat --}}
                <div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi Cepat</h3>
                            <div class="flex flex-col space-y-3">
                                <a href="#" class="w-full text-center rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600">
                                    Ajukan Surat Keterangan
                                </a>
                                <a href="#" class="w-full text-center rounded-md bg-gray-200 px-3.5 py-2.5 text-sm font-semibold text-gray-800 shadow-sm hover:bg-gray-300">
                                    Lihat Riwayat Pengajuan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>