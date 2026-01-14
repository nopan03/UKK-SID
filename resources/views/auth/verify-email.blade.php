<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <h2 class="text-xl font-bold text-gray-800 mb-2">Verifikasi Email</h2>
        {{ __('Kami telah mengirimkan kode 6 digit ke email: ') }} 
        <span class="font-bold text-green-700">{{ Auth::user()->email }}</span>.
        <br>
        {{ __('Masukkan kode tersebut di bawah ini untuk mengaktifkan akun.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 font-medium text-sm text-red-600 bg-red-50 p-3 rounded">
            {{ $errors->first('otp') }}
        </div>
    @endif

    <form id="otp-verification-form" method="POST" action="{{ route('otp.check') }}">
        @csrf

        <div class="mt-4">
            <x-input-label for="otp" :value="__('Kode OTP (Cek Email Anda)')" />
            
            <x-text-input id="otp" class="block mt-1 w-full text-center text-3xl font-mono tracking-[0.5em] py-3" 
                          type="text" name="otp" required autofocus 
                          placeholder="------" maxlength="6" />
        </div>
    </form>

    <div class="flex items-center justify-between mt-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-gray-600 hover:text-gray-900 underline">
                Log Out
            </button>
        </form>

        <x-primary-button form="otp-verification-form" class="ml-3">
            {{ __('Verifikasi Akun') }}
        </x-primary-button>
    </div>
    
    <div class="mt-6 text-center border-t pt-4">
        <p class="text-sm text-gray-600">Tidak menerima kode?</p>
        <form method="POST" action="{{ route('otp.resend') }}">
            @csrf
            <button type="submit" class="mt-2 text-green-700 font-bold hover:underline text-sm">
                Kirim Ulang Kode
            </button>
        </form>
    </div>
</x-guest-layout>