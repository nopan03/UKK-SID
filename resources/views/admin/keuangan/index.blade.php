@extends('layouts.admin') {{-- 1. GUNAKAN LAYOUT ADMIN --}}

@section('title', 'Manajemen Keuangan Desa')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- HEADER HALAMAN --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Laporan Keuangan</h1>
            <p class="text-sm text-gray-500">Rekapitulasi pemasukan dan pengeluaran anggaran desa.</p>
        </div>
        
        {{-- Tombol Tambah --}}
        <a href="{{ route('admin.keuangan.create') }}" class="mt-4 md:mt-0 flex items-center bg-green-700 hover:bg-green-800 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Transaksi
        </a>
    </div>

    {{-- CARD RINGKASAN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-green-500">
            <div class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">Total Pemasukan</div>
            <div class="text-2xl font-bold text-green-600">
                Rp {{ number_format($total_pemasukan, 0, ',', '.') }}
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-red-500">
            <div class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">Total Pengeluaran</div>
            <div class="text-2xl font-bold text-red-600">
                Rp {{ number_format($total_pengeluaran, 0, ',', '.') }}
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow border-l-4 border-blue-500">
            <div class="text-gray-500 text-xs uppercase font-bold tracking-wider mb-1">Saldo Akhir</div>
            <div class="text-2xl font-bold text-gray-800">
                Rp {{ number_format($saldo_akhir, 0, ',', '.') }}
            </div>
        </div>
    </div>

    {{-- TABEL DATA --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th scope="col" class="px-6 py-3">Tanggal</th>
                        <th scope="col" class="px-6 py-3">Keterangan</th>
                        <th scope="col" class="px-6 py-3">Jenis</th>
                        <th scope="col" class="px-6 py-3 text-right">Jumlah (Rp)</th>
                        <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksis as $transaksi)
                        <tr class="bg-white border-b hover:bg-gray-50 transition">
                            {{-- Tanggal --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-900 font-medium">
                                    {{ \Carbon\Carbon::parse($transaksi->tanggal)->translatedFormat('d F Y') }}
                                </div>
                            </td>
                            
                            {{-- Keterangan --}}
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ Str::limit($transaksi->keterangan, 50) }}
                            </td>

                            {{-- Jenis (Badge) --}}
                            <td class="px-6 py-4">
                                @if ($transaksi->jenis == 'pemasukan')
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-300">
                                        <i class="fas fa-arrow-up mr-1"></i> Pemasukan
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-300">
                                        <i class="fas fa-arrow-down mr-1"></i> Pengeluaran
                                    </span>
                                @endif
                            </td>

                            {{-- Jumlah --}}
                            <td class="px-6 py-4 text-right font-bold {{ $transaksi->jenis == 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                {{ number_format($transaksi->jumlah, 0, ',', '.') }}
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex item-center justify-center space-x-2">
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.keuangan.edit', $transaksi->id) }}" class="p-2 text-yellow-600 hover:bg-yellow-100 rounded transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.keuangan.destroy', $transaksi->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data transaksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded transition" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500 bg-gray-50">
                                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <p class="text-lg font-medium">Belum ada data transaksi.</p>
                                <p class="text-sm">Silakan catat pemasukan atau pengeluaran baru.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
@endsection