<div class="bg-white p-6 md:p-8 rounded-xl shadow-md border border-gray-100 mb-8">
    <h3 class="text-lg font-bold text-gray-800 mb-1">Ganti Password</h3>
    <p class="text-sm text-gray-500 mb-6">
        Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.
    </p>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Password Saat Ini</label>
            <input type="password" name="current_password" id="current_password" autocomplete="current-password"
                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition">
            @error('current_password', 'updatePassword') 
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input type="password" name="password" id="password" autocomplete="new-password"
                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition">
            @error('password', 'updatePassword') 
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                Konfirmasi Password Baru
            </label>
            <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring focus:ring-green-200 transition">
            @error('password_confirmation', 'updatePassword') 
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p> 
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-6 rounded-lg shadow transition">
                Update Password
            </button>
        </div>
    </form>
</div>
