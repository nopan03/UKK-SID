@extends('layouts.admin')

@section('title', 'Daftar Keluhan Masuk')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    {{-- HEADER --}}
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Keluhan & Aspirasi</h1>
            <p class="text-sm text-gray-500">Daftar laporan yang <span class="font-bold text-red-500">perlu ditindaklanjuti</span>.</p>
        </div>

        {{-- Pencarian --}}
        <form method="GET" action="{{ route('admin.keluhan.index') }}" class="flex w-full md:w-auto">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Pelapor / Masalah..." 
                class="w-full md:w-64 rounded-l-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 text-sm">
            <button type="submit" class="bg-green-700 text-white px-4 rounded-r-lg hover:bg-green-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-6 border-l-4 border-green-500 shadow-sm flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">Waktu Lapor</th>
                        <th class="px-6 py-3">Pelapor</th>
                        <th class="px-6 py-3">Perihal</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($keluhans as $keluhan)
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-bold text-gray-800">{{ $keluhan->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $keluhan->created_at->format('H:i') }} WIB</div>
                        </td>
                        <td class="px-6 py-4 text-gray-900 font-medium">
                            {{ $keluhan->user->name ?? 'Warga' }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            <span class="font-bold">{{ Str::limit($keluhan->judul, 30) }}</span>
                            <br>
                            <span class="text-xs text-gray-500">{{ Str::limit($keluhan->isi, 50) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $status = strtolower($keluhan->status);
                            @endphp
                            @if($status == 'pending' || $status == 'menunggu')
                                <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold border border-red-200 animate-pulse">
                                    Segera Cek
                                </span>
                            @elseif($status == 'proses' || $status == 'diproses')
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-bold border border-blue-200">
                                    Sedang Diproses
                                </span>
                            @elseif($status == 'selesai')
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                    Selesai
                                </span>
                            @elseif($status == 'ditolak')
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-bold border border-gray-200">
                                    Ditolak
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.keluhan.show', $keluhan->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition shadow-md transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-16">
                            <div class="flex flex-col items-center">
                                <div class="bg-green-100 p-4 rounded-full mb-3">
                                    <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <p class="text-lg font-bold text-gray-700">Pekerjaan Selesai!</p>
                                <p class="text-gray-500 text-sm">Tidak ada keluhan baru yang perlu ditangani saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $keluhans->links() }}
        </div>
    </div>
</div>
@endsection