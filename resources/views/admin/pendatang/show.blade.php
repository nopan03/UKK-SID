@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    
    {{-- Tombol Kembali --}}
    <a href="{{ route('admin.pendatang.index') }}" class="inline-flex items-center text-gray-600 hover:text-green-700 font-medium mb-6 transition">
        <i class="ti ti-arrow-left mr-2"></i> Kembali ke Daftar
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- KOLOM KIRI: FOTO BUKTI --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="p-4 bg-gray-50 border-b font-bold text-gray-700 flex justify-between items-center">
                    <span>Bukti Lampiran</span>
                    <a href="{{ asset('storage/' . $pendatang->foto_surat) }}" target="_blank" class="text-xs text-blue-600 hover:underline">
                        <i class="ti ti-external-link"></i> Buka Asli
                    </a>
                </div>
                <div class="p-4">
                    <img src="{{ asset('storage/' . $pendatang->foto_surat) }}" 
                         alt="Foto KTP/Surat" 
                         class="w-full h-auto rounded-lg border border-gray-200 hover:scale-105 transition duration-500 cursor-zoom-in"
                         onclick="window.open(this.src)">
                    <p class="text-xs text-center text-gray-400 mt-2">Klik gambar untuk memperbesar</p>
                </div>
            </div>

            {{-- Card Status --}}
            <div class="mt-6 bg-white rounded-xl shadow-md p-6 border-t-4 {{ $pendatang->status == 'disetujui' ? 'border-green-500' : ($pendatang->status == 'ditolak' ? 'border-red-500' : 'border-yellow-400') }}">
                <h4 class="text-sm font-bold text-gray-500 uppercase">Status Pengajuan</h4>
                
                @if($pendatang->status == 'menunggu')
                    <span class="mt-2 block text-2xl font-bold text-yellow-600 flex items-center gap-2">
                        <i class="ti ti-clock"></i> Menunggu
                    </span>
                    <p class="text-sm text-gray-500 mt-1">Perlu tindakan verifikasi Anda.</p>
                @elseif($pendatang->status == 'disetujui')
                    <span class="mt-2 block text-2xl font-bold text-green-600 flex items-center gap-2">
                        <i class="ti ti-circle-check"></i> Disetujui
                    </span>
                    <p class="text-sm text-gray-500 mt-1">Diverifikasi pada: {{ $pendatang->updated_at->format('d M Y H:i') }}</p>
                @else
                    <span class="mt-2 block text-2xl font-bold text-red-600 flex items-center gap-2">
                        <i class="ti ti-circle-x"></i> Ditolak
                    </span>
                    <p class="text-sm text-gray-500 mt-1">Alasan: "{{ $pendatang->pesan_admin }}"</p>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN: BIODATA & AKSI --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Biodata Card --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-green-700 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        <i class="ti ti-user"></i> Biodata Pelapor
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-8">
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Nama Lengkap</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $pendatang->user->name }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">NIK</label>
                            <p class="text-lg font-semibold text-gray-800">{{ $pendatang->user->nik }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">TTL</label>
                            <p class="text-base text-gray-700">{{ $pendatang->tempat_lahir }}, {{ \Carbon\Carbon::parse($pendatang->tanggal_lahir)->translatedFormat('d F Y') }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Jenis Kelamin</label>
                            <p class="text-base text-gray-700">{{ $pendatang->jenis_kelamin }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Agama</label>
                            <p class="text-base text-gray-700">{{ $pendatang->agama }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Status Perkawinan</label>
                            <p class="text-base text-gray-700">{{ $pendatang->status_perkawinan }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Pekerjaan</label>
                            <p class="text-base text-gray-700">{{ $pendatang->pekerjaan }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Keperluan Menetap</label>
                            <p class="text-base text-gray-700">{{ $pendatang->keperluan }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-xs text-gray-500 uppercase font-bold tracking-wider">Alamat Asal (KTP)</label>
                            <p class="text-base text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-200 mt-1">
                                {{ $pendatang->alamat_asal }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- AKSI ADMIN (Hanya muncul jika status 'menunggu') --}}
            @if($pendatang->status == 'menunggu')
            <div class="bg-white rounded-xl shadow-md p-6">
                <h4 class="text-lg font-bold text-gray-800 mb-4">Tindakan Verifikasi</h4>
                <div class="flex flex-col sm:flex-row gap-4">
                    
                    {{-- Form Terima --}}
                    <form action="{{ route('admin.pendatang.update', $pendatang->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin terima data ini? Role akun akan otomatis menjadi Warga.');">
                        @csrf @method('PUT')
                        <input type="hidden" name="action" value="terima">
                        <button type="submit" class="w-full py-3 px-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow transition transform hover:-translate-y-1 flex justify-center items-center gap-2">
                            <i class="ti ti-check"></i> Terima & Verifikasi
                        </button>
                    </form>

                    {{-- Tombol Tolak (Trigger Modal) --}}
                    <button onclick="document.getElementById('rejectArea').classList.toggle('hidden')" class="flex-1 py-3 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-lg shadow transition transform hover:-translate-y-1 flex justify-center items-center gap-2">
                        <i class="ti ti-x"></i> Tolak Laporan
                    </button>
                </div>

                {{-- Area Form Tolak (Hidden by default) --}}
                <div id="rejectArea" class="hidden mt-6 pt-6 border-t border-gray-200 animate-fade-in-down">
                    <form action="{{ route('admin.pendatang.update', $pendatang->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="action" value="tolak">
                        <label class="block text-sm font-bold text-red-700 mb-2">Alasan Penolakan:</label>
                        <textarea name="alasan" class="w-full border-red-300 rounded-lg focus:ring-red-500 focus:border-red-500" rows="3" required placeholder="Contoh: Foto KTP buram, NIK tidak sesuai..."></textarea>
                        <div class="mt-3 flex justify-end">
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-800 font-bold text-sm">
                                Kirim Penolakan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection