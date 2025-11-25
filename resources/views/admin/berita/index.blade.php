@extends('layouts.admin') {{-- 1. GUNAKAN LAYOUT ADMIN --}}

@section('title', 'Manajemen Berita Desa')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER HALAMAN --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Berita</h1>
            <p class="text-sm text-gray-500">Kelola artikel, pengumuman, dan berita desa disini.</p>
        </div>
        
        {{-- Tombol Tulis Berita --}}
        <a href="{{ route('admin.berita.create') }}" class="mt-4 md:mt-0 flex items-center bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Tulis Berita Baru
        </a>
    </div>

    {{-- ALERT SUKSES --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center">
            <div>
                <p class="font-bold">Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    {{-- TABEL BERITA --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th scope="col" class="px-6 py-3">No</th>
                        <th scope="col" class="px-6 py-3">Judul Berita</th>
                        <th scope="col" class="px-6 py-3">Kategori</th>
                        <th scope="col" class="px-6 py-3">Penulis</th>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($beritas as $index => $berita)
                        <tr class="bg-white border-b hover:bg-gray-50 transition">
                            {{-- Nomor Urut --}}
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $beritas->firstItem() + $index }}
                            </td>
                            
                            {{-- Judul (Truncate agar tidak kepanjangan) --}}
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 line-clamp-2" title="{{ $berita->judul }}">
                                    {{ Str::limit($berita->judul, 50) }}
                                </div>
                            </td>

                            {{-- Kategori --}}
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded border border-blue-400">
                                    {{ $berita->kategori }}
                                </span>
                            </td>

                            {{-- Penulis (Handle jika user dihapus) --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 mr-2 font-bold text-xs">
                                        {{ substr($berita->user->name ?? 'X', 0, 1) }}
                                    </div>
                                    <span class="text-gray-700 font-medium">
                                        {{ $berita->user->name ?? 'Penulis Dihapus' }}
                                    </span>
                                </div>
                            </td>

                            {{-- Tanggal --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-xs text-gray-500">
                                    <i class="far fa-calendar-alt mr-1"></i>
                                    {{ \Carbon\Carbon::parse($berita->created_at)->format('d M Y') }}
                                </div>
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex item-center justify-center space-x-2">
                                    {{-- Lihat --}}
                                    <a href="{{ route('admin.berita.show', $berita->id) }}" class="p-2 text-blue-600 hover:bg-blue-100 rounded transition" title="Lihat Berita">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="p-2 text-yellow-600 hover:bg-yellow-100 rounded transition" title="Edit Berita">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded transition" title="Hapus Berita">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                <p class="text-lg font-medium">Belum ada berita.</p>
                                <p class="text-sm">Silakan mulai menulis berita atau pengumuman desa.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $beritas->links() }}
        </div>
    </div>
</div>
@endsection