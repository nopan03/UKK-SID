<x-app-layout>
    <x-slot name="header">
        <div class="bg-green-700 py-6 -mx-6 -mt-6 px-6 text-white shadow-md">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between max-w-7xl mx-auto">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold mb-1">Pengaturan Profil</h1>
                    <p class="text-green-100 text-sm">Kelola informasi akun dan biodata kependudukan Anda.</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- 
                PERUBAHAN 1: 'items-stretch' 
                Ini memaksa kolom Kiri dan Kanan memiliki tinggi fisik yang SAMA persis.
            --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

                {{-- ========================================== --}}
                {{-- KOLOM KIRI (Biodata + Hapus Akun) --}}
                {{-- ========================================== --}}
                {{-- 
                    PERUBAHAN 2: 'flex flex-col' 
                    Kita ubah kolom ini jadi Flexbox vertikal agar bisa mengatur posisi elemen.
                --}}
                <div class="lg:col-span-2 flex flex-col gap-6">
                    
                    {{-- 1. Biodata --}}
                    <div>
                        @include('profile.partials.show-biodata-information', ['user' => $user])
                    </div>

                    {{-- 2. Hapus Akun --}}
                    {{-- 
                        PERUBAHAN 3: 'mt-auto'
                        Ini adalah kuncinya! 'margin-top: auto' akan mendorong kotak ini 
                        sampai mentok ke paling bawah kolom, sehingga sejajar dengan kanan.
                    --}}
                    <div class="mt-auto p-4 sm:p-5 bg-white shadow sm:rounded-lg border border-red-100">
                        <h3 class="text-md font-bold text-red-600 mb-3 border-b border-red-100 pb-2 flex items-center">
                            <i class="ti ti-alert-triangle mr-2"></i> Zona Bahaya
                        </h3>
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>

                {{-- ========================================== --}}
                {{-- KOLOM KANAN (Edit Akun + Password) --}}
                {{-- ========================================== --}}
                <div class="flex flex-col gap-6 h-full">

                    {{-- 3. Edit Akun --}}
                    <div class="p-4 sm:p-5 bg-white shadow sm:rounded-lg">
                        <h3 class="text-md font-bold text-gray-900 mb-3 border-b pb-2 flex items-center">
                            <i class="ti ti-settings mr-2"></i> Akun Pengguna
                        </h3>
                        @include('profile.partials.update-profile-information-form', ['user' => $user])
                    </div>

                    {{-- 4. Ganti Password --}}
                    {{-- Kita pasang h-full agar dia mengisi sisa ruang jika ada --}}
                    <div class="p-4 sm:p-5 bg-white shadow sm:rounded-lg flex-grow h-full">
                        <div class="h-full flex flex-col">
                            <h3 class="text-md font-bold text-gray-900 mb-3 border-b pb-2 flex items-center">
                                <i class="ti ti-lock mr-2"></i> Keamanan
                            </h3>
                            <div class="flex-grow">
                                @include('profile.partials.update-password-form')
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>