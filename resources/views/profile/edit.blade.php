<x-app-layout>
    <x-slot name="header">
        <div class="bg-green-700 py-6 -mx-6 -mt-6 px-6 text-white">
            <h1 class="text-2xl md:text-3xl font-bold mb-1">Pengaturan Profil</h1>
            <p class="text-green-100 text-sm">Kelola informasi akun dan biodata Anda.</p>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- BIODATA LENGKAP (READONLY) --}}
            @include('profile.partials.show-biodata-information', ['user' => $user])

            {{-- FORM INFORMASI AKUN (nama + email) --}}
            @include('profile.partials.update-profile-information-form', ['user' => $user])

            {{-- GANTI PASSWORD --}}
            @include('profile.partials.update-password-form')

            {{-- HAPUS AKUN --}}
            @include('profile.partials.delete-user-form')

        </div>
    </div>
</x-app-layout>
