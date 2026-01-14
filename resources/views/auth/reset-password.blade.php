<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        Kode OTP telah dikirim ke email Anda. Silakan masukkan <strong>Kode OTP</strong> dan <strong>Password Baru</strong> Anda di bawah ini.
    </div>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update.otp') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email Anda" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-100 text-gray-500" type="email" name="email" :value="request()->get('email')" readonly />
        </div>

        <div class="mt-4">
            <x-input-label for="otp" value="Kode OTP (6 Digit)" />
            <x-text-input id="otp" class="block mt-1 w-full text-center text-xl font-bold tracking-widest" type="text" name="otp" required placeholder="------" maxlength="6" autofocus />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password Baru" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Ulangi Password Baru" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password Sekarang') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>