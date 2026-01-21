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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">

                {{-- KOLOM KIRI (Biodata + Hapus Akun) --}}
                <div class="lg:col-span-2 flex flex-col gap-6">
                    <div>
                        @include('profile.partials.show-biodata-information', ['user' => $user])
                    </div>
                    <div class="mt-auto p-4 sm:p-5 bg-white shadow sm:rounded-lg border border-red-100">
                        <h3 class="text-md font-bold text-red-600 mb-3 border-b border-red-100 pb-2 flex items-center">
                            <i class="ti ti-alert-triangle mr-2"></i> Zona Bahaya
                        </h3>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>

                {{-- KOLOM KANAN (Edit Akun + Ganti Password) --}}
                <div class="flex flex-col gap-6 h-full">

                    {{-- 1. Edit Akun (Email Readonly) --}}
                    <div class="p-4 sm:p-5 bg-white shadow sm:rounded-lg">
                        <h3 class="text-md font-bold text-gray-900 mb-3 border-b pb-2 flex items-center">
                            <i class="ti ti-settings mr-2"></i> Akun Pengguna
                        </h3>
                        <form method="post" action="{{ route('profile.update') }}" class="mt-4 space-y-4">
                            @csrf @method('patch')
                            <div>
                                <x-input-label for="name" :value="__('Nama Lengkap')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full bg-gray-100 cursor-not-allowed text-gray-500" :value="old('email', $user->email)" readonly />
                                <p class="text-xs text-red-500 mt-1">*Email terhubung dengan data kependudukan.</p>
                            </div>
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Simpan Profil') }}</x-primary-button>
                                @if (session('status') === 'profile-updated')
                                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-green-600 font-bold">{{ __('Tersimpan.') }}</p>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- 2. Ganti Password (LOGIKA BARU) --}}
                    <div class="p-4 sm:p-5 bg-white shadow sm:rounded-lg flex-grow h-full">
                        <div class="h-full flex flex-col">
                            <h3 class="text-md font-bold text-gray-900 mb-3 border-b pb-2 flex items-center">
                                <i class="ti ti-lock mr-2"></i> Ganti Password
                            </h3>

                            {{-- Menggunakan Alpine JS untuk switch tampilan Form vs OTP --}}
                            <div class="flex-grow" x-data="{ showOtp: {{ session('otp_sent') ? 'true' : 'false' }} }">
                                
                                {{-- PESAN SUKSES --}}
                                @if (session('status') === 'password-updated')
                                    <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 p-3 rounded-lg border border-green-200">
                                        ✅ Password berhasil diperbarui!
                                    </div>
                                @endif

                                {{-- TAMPILAN 1: FORMULIR PASSWORD --}}
                                <div x-show="!showOtp">
                                    <p class="text-sm text-gray-600 mb-4">
                                        Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
                                    </p>

                                    <form method="post" action="{{ route('profile.password.initiate') }}" class="space-y-4">
                                        @csrf
                                        
                                        {{-- Password Saat Ini --}}
                                        <div>
                                            <x-input-label for="current_password" :value="__('Password Saat Ini')" />
                                            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
                                            <x-input-error :messages="$errors->get('current_password')" class="mt-2" />
                                            
                                            {{-- Tombol Lupa Password --}}
                                            <div class="mt-1 text-right">
                                                 <button form="form-forgot" type="submit" class="text-xs text-blue-600 hover:text-blue-800 underline">
                                                    Lupa password saya?
                                                </button>
                                            </div>
                                        </div>

                                        {{-- Password Baru --}}
                                        <div>
                                            <x-input-label for="password" :value="__('Password Baru')" />
                                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                        </div>

                                        {{-- Konfirmasi Password --}}
                                        <div>
                                            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password Baru')" />
                                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                        </div>

                                        <x-primary-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 focus:bg-yellow-500 active:bg-yellow-700">
                                            {{ __('Update Password') }}
                                        </x-primary-button>
                                    </form>

                                    {{-- FORM TERSEMBUNYI UNTUK LUPA PASSWORD --}}
                                    <form id="form-forgot" method="POST" action="{{ route('profile.forgot.logged_in') }}" class="hidden">@csrf</form>
                                </div>

                                {{-- TAMPILAN 2: INPUT OTP (Muncul setelah password lama benar) --}}
                                <div x-show="showOtp" style="display: none;" x-transition>
                                    <form method="post" action="{{ route('profile.password.confirm') }}" class="space-y-4 mt-4">
                                        @csrf
                                        @method('put')

                                        <div class="bg-green-50 border border-green-200 p-3 rounded-md text-sm text-green-800">
                                            <strong>Langkah Terakhir!</strong><br>
                                            Password lama Anda benar. Kami telah mengirim kode OTP ke <b>{{ $user->email }}</b> untuk verifikasi.
                                        </div>

                                        <div>
                                            <x-input-label for="otp_code" :value="__('Masukkan Kode OTP')" />
                                            <x-text-input id="otp_code" name="otp_code" type="text" class="mt-1 block w-full text-center text-2xl tracking-widest font-bold" placeholder="000000" required />
                                            <x-input-error :messages="$errors->get('otp_code')" class="mt-2" />
                                        </div>

                                        <div class="flex flex-col gap-2">
                                            <x-primary-button class="w-full justify-center">{{ __('Verifikasi & Simpan') }}</x-primary-button>
                                            
                                            <a href="{{ route('profile.edit') }}" class="text-sm text-gray-500 hover:text-gray-900 underline text-center block py-2">
                                                {{ __('Batal') }}
                                            </a>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>