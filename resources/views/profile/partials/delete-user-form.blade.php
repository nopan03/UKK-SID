<div class="bg-red-50 p-6 md:p-8 rounded-xl shadow-inner border border-red-100">
    <h3 class="text-lg font-bold text-red-800 mb-1">Hapus Akun</h3>
    <p class="text-sm text-red-600 mb-6">
        Setelah akun dihapus, semua data dan sumber daya terkait akan dihapus secara permanen. 
        Silakan unduh data yang ingin Anda simpan sebelum menghapus.
    </p>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg shadow transition">
        Hapus Akun Saya
    </button>

    {{-- Modal Konfirmasi Hapus (Menggunakan Komponen Blade Bawaan Breeze) --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Apakah Anda yakin ingin menghapus akun?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Setelah dihapus, data tidak bisa dikembalikan. Masukkan password Anda untuk konfirmasi.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Hapus Akun') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
