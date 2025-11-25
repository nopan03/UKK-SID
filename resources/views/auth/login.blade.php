<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label for="email" class="block font-medium text-sm text-gray-700">Email</label>
            <input id="email" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm" 
                   type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                   placeholder="Masukkan email Anda" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <label for="password" class="block font-medium text-sm text-gray-700">Kata Sandi</label>
            <input id="password" class="block mt-1 w-full border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="Masukkan kata sandi" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-green-600 hover:text-green-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500" href="{{ route('password.request') }}">
                    Lupa kata sandi?
                </a>
            @endif
        </div>

        <div class="mt-6">
            <button class="w-full justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-green-700 hover:bg-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                MASUK SEKARANG
            </button>
        </div>
        
        <div class="relative flex py-5 items-center">
            <div class="flex-grow border-t border-gray-200"></div>
            <span class="flex-shrink-0 mx-4 text-gray-400 text-sm">Belum punya akun?</span>
            <div class="flex-grow border-t border-gray-200"></div>
        </div>

        @if (Route::has('register'))
            <div class="mt-1 text-center">
                <a href="{{ route('register') }}" class="w-full inline-flex justify-center py-3 px-4 border-2 border-primary-yellow rounded-md shadow-sm text-sm font-bold text-gray-700 bg-white hover:bg-yellow-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition ease-in-out duration-150">
                    DAFTAR AKUN BARU
                </a>
            </div>
        @endif
    </form>
</x-guest-layout>