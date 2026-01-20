@extends('layouts.admin')

@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="container mx-auto px-4 py-6">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Log Aktivitas (Firebase)</h1>
        <p class="text-sm text-gray-500">Memantau aktivitas pengguna secara Realtime.</p>
    </div>

    <div class="bg-white rounded-xl shadow overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3">Waktu</th>
                        <th class="px-6 py-3">Pengguna</th>
                        {{-- <th class="px-6 py-3">Peran</th> --}} {{-- HAPUS INI KARENA KITA BELUM SIMPAN ROLE DI FIREBASE --}}
                        <th class="px-6 py-3">Aktivitas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $key => $log)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-500 text-sm">
                                {{-- Parsing Tanggal --}}
                                {{ \Carbon\Carbon::parse($log['waktu'])->translatedFormat('d F Y, H:i') }}
                            </td>
                            <td class="px-6 py-4 font-bold text-gray-800">
                                {{ $log['user_name'] ?? 'Guest' }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $log['aktivitas'] }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <p>Belum ada aktivitas tercatat di Firebase.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- 🔥 BAGIAN INI SUDAH DIHAPUS AGAR TIDAK ERROR 🔥 --}}
        {{-- 
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $logs->links() }}
        </div> 
        --}}
    </div>
</div>
@endsection