<x-app-layout>
    {{-- Kita tidak lagi menggunakan <x-slot name="header"> karena sudah dihapus dari layout utama --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    {{-- Judul halaman kita letakkan di sini --}}
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        Manajemen Data Warga
                    </h3>

                    {{-- Tombol untuk Tambah Warga Baru --}}
                    <div class="mb-4">
                        <a href="{{ route('admin.warga.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            + Tambah Warga Baru
                        </a>
                    </div>
                    
                    {{-- Menampilkan pesan sukses setelah menambah/mengubah/menghapus data --}}
                    @if (session('success'))
                        <div class="mb-4 rounded-lg bg-green-100 p-4 text-sm text-green-700" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Tabel untuk menampilkan data warga --}}
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="text-left bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">NIK</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Nama</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Alamat</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($warga as $data)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ $data->nik }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $data->nama }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ Str::limit($data->alamat, 50) }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 space-x-2">
                                            <a href="{{ route('admin.warga.show', $data->id) }}" class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">View</a>
                                            <a href="{{ route('admin.warga.edit', $data->id) }}" class="inline-block rounded bg-yellow-500 px-4 py-2 text-xs font-medium text-white hover:bg-yellow-600">Edit</a>
                                            <form action="{{ route('admin.warga.destroy', $data->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-block rounded bg-red-600 px-4 py-2 text-xs font-medium text-white hover:bg-red-700">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-gray-500 py-4">
                                            Data warga masih kosong. Silakan tambahkan data baru.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    {{-- Link untuk Paginasi --}}
                    <div class="mt-4">
                        {{ $warga->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>