@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Log Aktivitas</h1>
        <p class="text-sm text-gray-500">Memantau aktivitas pengguna di dalam sistem.</p>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">Pengguna</th>
                        <th class="px-6 py-3">Peran</th>
                        <th class="px-6 py-3">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                        {{-- Kolom Waktu --}}
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($log->waktu)->format('d M Y') }}
                            <br>
                            <span class="text-xs text-gray-400">
                                {{ \Carbon\Carbon::parse($log->waktu)->format('H:i:s') }}
                            </span>
                        </td>

                        {{-- Kolom Pengguna --}}
                        <td class="px-6 py-4 font-bold text-gray-900">
                            {{ $log->user->name ?? 'User Terhapus' }}
                        </td>

                        {{-- Kolom Peran --}}
                        <td class="px-6 py-4">
                            @if(optional($log->user)->role == 'admin')
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-0.5 rounded border border-green-200">Admin</span>
                            @else
                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-0.5 rounded border border-blue-200">Warga</span>
                            @endif
                        </td>

                        {{-- Kolom Aktivitas --}}
                        <td class="px-6 py-4 text-gray-700">
                            {{ $log->aktivitas }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                            Belum ada aktivitas tercatat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection