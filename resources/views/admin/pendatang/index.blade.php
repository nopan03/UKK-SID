@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    {{-- Judul Halaman --}}
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Verifikasi Warga Pendatang</h2>

    {{-- Alert Sukses --}}
    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow flex items-center justify-between">
            <div class="flex items-center">
                <i class="ti ti-circle-check text-xl mr-2"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold hover:text-green-900">&times;</button>
        </div>
    @endif

    {{-- CARD CONTAINER (HEADER HIJAU) --}}
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        {{-- TABLE CONTENT --}}
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 uppercase text-xs tracking-wider font-bold">
                        <th class="px-6 py-3 text-left">No</th>
                        <th class="px-6 py-3 text-left">Tanggal & Waktu</th>
                        <th class="px-6 py-3 text-left">Pelapor / NIK</th>
                        <th class="px-6 py-3 text-left">Keperluan</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($pendatang as $index => $item)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        
                        {{-- Nomor --}}
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $pendatang->firstItem() + $index }}
                        </td>

                        {{-- Tanggal --}}
                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                            <div class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                            </div>
                            <div class="text-xs text-gray-500 mt-0.5">
                                Pukul {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }} WIB
                            </div>
                        </td>

                        {{-- Pelapor --}}
                        <td class="px-6 py-4 text-sm">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-8 w-8 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold mr-3">
                                    {{ substr($item->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900">{{ $item->user->name }}</div>
                                    <div class="text-gray-500 text-xs">{{ $item->user->nik }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Keperluan --}}
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ Str::limit($item->keperluan, 35) }}
                        </td>

                        {{-- Status Badge --}}
                        <td class="px-6 py-4 text-center">
                            @if($item->status == 'menunggu')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-yellow-100 text-yellow-800 border border-yellow-200 shadow-sm">
                                    <i class="ti ti-clock mr-1"></i> Menunggu
                                </span>
                            @elseif($item->status == 'disetujui')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                    <i class="ti ti-circle-check mr-1"></i> Disetujui
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-red-100 text-red-800 border border-red-200 shadow-sm">
                                    <i class="ti ti-circle-x mr-1"></i> Ditolak
                                </span>
                            @endif
                        </td>

                        {{-- Aksi (Detail & Delete) --}}
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center items-center space-x-2">
                                
                                {{-- Tombol Detail (Mata Biru) --}}
                                <a href="{{ route('admin.pendatang.show', $item->id) }}" 
                                   class="group text-blue-500 hover:text-blue-700 bg-blue-50 hover:bg-blue-100 p-2 rounded-lg transition"
                                   title="Lihat Detail & Verifikasi">
                                    <i class="ti ti-eye text-lg"></i>
                                </a>

                                {{-- Tombol Hapus (Sampah Merah) --}}
                                <form action="{{ route('admin.pendatang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data laporan ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="group text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition"
                                            title="Hapus Data">
                                        <i class="ti ti-trash text-lg"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-gray-100 p-4 rounded-full mb-3">
                                    <i class="ti ti-clipboard-list text-4xl text-gray-400"></i>
                                </div>
                                <p class="text-lg font-semibold text-gray-600">Belum ada data pelaporan.</p>
                                <p class="text-sm text-gray-400">Data warga pendatang yang melapor akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        @if($pendatang->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $pendatang->links() }}
            </div>
        @endif
    </div>
</div>
@endsection