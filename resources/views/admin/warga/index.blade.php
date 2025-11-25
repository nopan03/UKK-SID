@extends('layouts.admin') {{-- Pastikan nama file layout admin Anda benar --}}

@section('title', 'Manajemen Data Warga')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER HALAMAN --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Data Penduduk Desa</h1>
            <p class="text-sm text-gray-500">Kelola data kependudukan desa Suruh disini.</p>
        </div>
        
        {{-- Tombol Tambah Warga --}}
        <a href="{{ route('admin.warga.create') }}" class="mt-4 md:mt-0 flex items-center bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Warga Baru
        </a>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm" role="alert">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- TABEL DATA --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">NIK & Nama</th>
                        <th scope="col" class="px-6 py-3">Jenis Kelamin</th>
                        <th scope="col" class="px-6 py-3">Alamat</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($warga as $index => $item)
                        <tr class="bg-white border-b hover:bg-gray-50 transition">
                            {{-- Nomor Urut (Memperhitungkan Pagination) --}}
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $warga->firstItem() + $index }}
                            </td>
                            
                            {{-- NIK & Nama --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900">{{ $item->nama }}</div>
                                <div class="text-xs text-gray-500">{{ $item->nik }}</div>
                            </td>

                            {{-- Jenis Kelamin --}}
                            <td class="px-6 py-4">
                                @if($item->jenis_kelamin == 'L')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">Laki-laki</span>
                                @else
                                    <span class="bg-pink-100 text-pink-800 text-xs font-medium px-2.5 py-0.5 rounded">Perempuan</span>
                                @endif
                            </td>

                            {{-- Alamat --}}
                            <td class="px-6 py-4 truncate max-w-xs">
                                {{ $item->alamat }}
                            </td>

                            {{-- Status Hidup --}}
                            <td class="px-6 py-4">
                                @if($item->status_hidup == 'hidup')
                                    <span class="flex items-center text-green-600 text-xs font-bold">
                                        <span class="w-2 h-2 rounded-full bg-green-600 mr-2"></span> Hidup
                                    </span>
                                @else
                                    <span class="flex items-center text-red-600 text-xs font-bold">
                                        <span class="w-2 h-2 rounded-full bg-red-600 mr-2"></span> Meninggal
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi (Tombol) --}}
                            <td class="px-6 py-4 text-center">
                                <div class="flex item-center justify-center space-x-2">
                                    {{-- Tombol Detail/Show --}}
                                    <a href="{{ route('admin.warga.show', $item->id) }}" class="p-2 text-blue-600 hover:bg-blue-100 rounded transition" title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.warga.edit', $item->id) }}" class="p-2 text-yellow-600 hover:bg-yellow-100 rounded transition" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('admin.warga.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data warga ini? Data yang dihapus tidak bisa dikembalikan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded transition" title="Hapus Data">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <p class="text-lg font-medium">Belum ada data warga.</p>
                                <p class="text-sm">Silakan tambahkan data warga baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $warga->links() }} 
        </div>
    </div>
</div>
@endsection