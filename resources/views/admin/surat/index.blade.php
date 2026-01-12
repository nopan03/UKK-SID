@extends('layouts.admin')

@section('title', 'Daftar Surat Masuk')

@section('content')
<div class="container mx-auto px-4 py-6">

    {{-- JUDUL & HEADER --}}
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Permohonan Surat Masuk</h1>
            <p class="text-sm text-gray-500">Kelola pengajuan surat warga.</p>
        </div>
        
        {{-- FORM PENCARIAN --}}
        <form method="GET" action="{{ route('admin.surat.index') }}" class="flex w-full md:w-auto">
            {{-- Simpan filter jenis/status jika ada --}}
            @if(request('jenis')) <input type="hidden" name="jenis" value="{{ request('jenis') }}"> @endif
            @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
            
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NIK..." 
                class="w-full md:w-64 rounded-l-lg border border-gray-300 focus:ring-green-500 focus:border-green-500 text-sm">
            <button type="submit" class="bg-green-700 text-white px-4 rounded-r-lg hover:bg-green-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>
        </form>
    </div>

    {{-- TAB FILTER STATUS (Navigasi Cepat) --}}
    <div class="flex space-x-2 border-b border-gray-200 mb-6 overflow-x-auto pb-1">
        
        {{-- Tab Semua --}}
        <a href="{{ route('admin.surat.index', ['jenis' => request('jenis')]) }}" 
           class="px-4 py-2 text-sm font-medium rounded-t-lg border-b-2 transition whitespace-nowrap
           {{ !request('status') ? 'border-green-600 text-green-700 bg-green-50' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
            Semua
        </a>

        {{-- Tab Menunggu (Penting!) --}}
        <a href="{{ route('admin.surat.index', array_merge(request()->query(), ['status' => 'menunggu'])) }}" 
           class="px-4 py-2 text-sm font-medium rounded-t-lg border-b-2 transition whitespace-nowrap flex items-center
           {{ request('status') == 'menunggu' ? 'border-yellow-500 text-yellow-700 bg-yellow-50' : 'border-transparent text-gray-500 hover:text-yellow-600 hover:border-yellow-300' }}">
            <span class="w-2 h-2 rounded-full bg-yellow-500 mr-2"></span> Menunggu
        </a>

        {{-- Tab Proses --}}
        <a href="{{ route('admin.surat.index', array_merge(request()->query(), ['status' => 'proses'])) }}" 
           class="px-4 py-2 text-sm font-medium rounded-t-lg border-b-2 transition whitespace-nowrap flex items-center
           {{ request('status') == 'proses' ? 'border-blue-500 text-blue-700 bg-blue-50' : 'border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-300' }}">
            <span class="w-2 h-2 rounded-full bg-blue-500 mr-2"></span> Diproses
        </a>

        {{-- Tab Selesai --}}
        <a href="{{ route('admin.surat.index', array_merge(request()->query(), ['status' => 'selesai'])) }}" 
           class="px-4 py-2 text-sm font-medium rounded-t-lg border-b-2 transition whitespace-nowrap flex items-center
           {{ request('status') == 'selesai' ? 'border-green-500 text-green-700 bg-green-50' : 'border-transparent text-gray-500 hover:text-green-600 hover:border-green-300' }}">
            <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span> Selesai
        </a>

        {{-- Tab Ditolak --}}
        <a href="{{ route('admin.surat.index', array_merge(request()->query(), ['status' => 'ditolak'])) }}" 
           class="px-4 py-2 text-sm font-medium rounded-t-lg border-b-2 transition whitespace-nowrap flex items-center
           {{ request('status') == 'ditolak' ? 'border-red-500 text-red-700 bg-red-50' : 'border-transparent text-gray-500 hover:text-red-600 hover:border-red-300' }}">
            <span class="w-2 h-2 rounded-full bg-red-500 mr-2"></span> Ditolak
        </a>
    </div>

    {{-- INFO FILTER AKTIF --}}
    @if(request('jenis') || request('search'))
        <div class="mb-4 flex items-center text-sm text-gray-600 bg-gray-100 px-3 py-2 rounded">
            <span class="mr-2">Filter aktif:</span>
            @if(request('jenis')) 
                <span class="font-bold mr-2">Jenis: {{ request('jenis') }}</span>
            @endif
            @if(request('search')) 
                <span class="font-bold mr-2">Cari: "{{ request('search') }}"</span>
            @endif
            <a href="{{ route('admin.surat.index') }}" class="ml-auto text-red-600 hover:underline font-bold text-xs">Reset Semua Filter</a>
        </div>
    @endif

    {{-- TABEL DATA (Sama seperti sebelumnya) --}}
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">Tanggal</th>
                        <th class="px-6 py-3">Pemohon</th>
                        <th class="px-6 py-3">Jenis Surat</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surats as $surat)
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $surat->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-400">{{ $surat->created_at->format('H:i') }} WIB</div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $surat->user->name ?? 'User Terhapus' }}</div>
                            <div class="text-xs text-gray-500">NIK: {{ $surat->user->nik ?? '-' }}</div>
                        </td>
                        
                        <td class="px-6 py-4">
                            <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-2.5 py-0.5 rounded border border-indigo-200 uppercase tracking-wide">
                                {{ $surat->jenis_surat }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4">
                            @if($surat->status == 'menunggu')
                                <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded border border-yellow-200">Menunggu</span>
                            @elseif($surat->status == 'proses')
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded border border-blue-200">Diproses</span>
                            @elseif($surat->status == 'selesai')
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded border border-green-200">Selesai</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded border border-red-200">Ditolak</span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('admin.surat.show', $surat->id) }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg transition shadow-md transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                Verifikasi
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <p class="text-lg font-medium text-gray-600">Tidak ada data yang cocok.</p>
                                @if(request('status') || request('search'))
                                    <a href="{{ route('admin.surat.index') }}" class="text-sm text-blue-600 hover:underline mt-2">Reset Filter</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $surats->links() }}
        </div>
    </div>
</div>
@endsection