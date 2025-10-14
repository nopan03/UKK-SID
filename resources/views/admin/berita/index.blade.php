<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Berita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <a href="{{ route('admin.berita.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                            + Tulis Berita Baru
                        </a>
                    </div>
                    
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700" role="alert">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="text-left bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Judul</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Kategori</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Penulis</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($beritas as $berita)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ Str::limit($berita->judul, 40) }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $berita->kategori }}</td>
                                        {{-- PERBAIKAN: Cek jika user ada sebelum menampilkan nama --}}
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $berita->user->name ?? 'Penulis Dihapus' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 space-x-2">
                                            {{-- PERBAIKAN: Semua link aksi sekarang benar --}}
                                            <a href="{{ route('admin.berita.show', $berita->id) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white">View</a>
                                            <a href="{{ route('admin.berita.edit', $berita->id) }}" class="inline-block rounded bg-yellow-500 px-4 py-2 text-xs font-medium text-white">Edit</a>
                                            <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus berita ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block rounded bg-red-600 px-4 py-2 text-xs font-medium text-white">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-gray-500 py-4">Belum ada berita.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">{{ $beritas->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>