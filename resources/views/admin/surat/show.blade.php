@extends('layouts.admin')

@section('title', 'Verifikasi Surat')

@section('content')

{{-- 
    1. NORMALISASI DATA (Agar tidak Error) 
    Baris ini mengubah data apapun menjadi Array standar. 
    Sehingga kita tidak perlu pusing apakah Controller mengirim Object atau Array.
--}}
@php
    $detail = (array) $detail; 
    $status = strtolower(trim($surat->status));
@endphp

<div class="container mx-auto px-4 py-6">

    {{-- HEADER --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Verifikasi Surat</h1>
            <p class="text-sm text-gray-500">Cek kelengkapan berkas sebelum menyetujui.</p>
        </div>
        <a href="{{ route('admin.surat.index') }}" class="text-gray-600 hover:text-gray-900 font-medium text-sm flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- KOLOM KIRI: Data & Berkas --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- 1. Info Pemohon --}}
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Data Pemohon</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Nama Lengkap</p>
                        <p class="font-semibold">{{ $surat->user->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">NIK</p>
                        <p class="font-semibold">{{ $surat->user->biodata->nik ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Jenis Surat</p>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded font-bold uppercase">{{ $surat->jenis_surat }}</span>
                    </div>
                    <div>
                        <p class="text-gray-500">Tanggal Request</p>
                        <p class="font-semibold">{{ $surat->created_at->translatedFormat('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            {{-- 2. Detail & Berkas --}}
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 mb-2 border-b pb-2">Detail & Berkas Lampiran</h3>

                {{-- Keterangan Warga --}}
                @if($surat->keterangan)
                    <div class="mb-4 bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-1">Catatan Warga</p>
                        <p class="text-sm text-gray-800 italic">"{{ $surat->keterangan }}"</p>
                    </div>
                @endif
                
                @if($detail)
                    <div class="space-y-6">
                        {{-- A. DATA TEXT (Bukan File) --}}
                        <div class="grid grid-cols-1 gap-y-3 text-sm border-b pb-4">
                            {{-- PERBAIKAN: Hapus '->toArray()' --}}
                            @foreach($detail as $key => $value)
                                @if(
                                    !in_array($key, ['id', 'surat_id', 'biodata_id', 'created_at', 'updated_at']) 
                                    && !str_contains($key, 'file_') 
                                    && $value
                                )
                                    <div class="grid grid-cols-3 border-b border-dashed pb-2 last:border-0">
                                        <div class="text-gray-500 capitalize font-medium">
                                            {{ str_replace('_', ' ', $key) }}
                                        </div>
                                        <div class="col-span-2 font-semibold text-gray-900 break-words">
                                            {{ $value }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- B. DATA FILE / GAMBAR --}}
                        <div>
                            <h4 class="font-bold text-gray-700 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                Berkas Lampiran
                            </h4>
                            
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                {{-- PERBAIKAN: Hapus '->toArray()' --}}
                                @foreach($detail as $key => $value)
                                    @if(str_contains($key, 'file_') && $value)
                                        @php
                                            $filePath = asset('storage/' . $value);
                                            $ext = strtolower(pathinfo($value, PATHINFO_EXTENSION));
                                            $label = ucwords(str_replace(['file_', '_'], [' ', ' '], $key));
                                        @endphp

                                        <div class="group border rounded-lg p-2 bg-gray-50 hover:bg-white hover:shadow-md transition duration-200">
                                            <p class="text-xs text-gray-500 mb-2 font-bold truncate text-center">{{ $label }}</p>

                                            <a href="{{ $filePath }}" target="_blank" class="block relative overflow-hidden rounded">
                                                @if($ext === 'pdf')
                                                    <div class="h-24 flex flex-col items-center justify-center bg-red-50 text-red-600 border border-red-100">
                                                        <svg class="w-8 h-8 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 2H7a2 2 0 00-2 2v15a2 2 0 002 2z" /></svg>
                                                        <span class="text-xs font-bold">Dokumen PDF</span>
                                                    </div>
                                                @else
                                                    <img src="{{ $filePath }}" alt="{{ $label }}" class="h-24 w-full object-cover transform group-hover:scale-110 transition duration-300">
                                                @endif
                                            </a>
                                            
                                            <a href="{{ $filePath }}" target="_blank" class="mt-2 block w-full text-center text-xs bg-indigo-50 text-indigo-700 py-1 rounded hover:bg-indigo-100 transition">
                                                Buka
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                        <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        <p>Detail surat tidak ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- KOLOM KANAN: Form Aksi --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow p-6 border border-gray-100 sticky top-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Tindakan Admin</h3>
                
                {{-- Status Badge --}}
                <div class="mb-6 text-center">
                    <p class="text-xs text-gray-500 uppercase mb-1">Status Saat Ini</p>
                    @if($status == 'menunggu')
                        <div class="bg-yellow-100 text-yellow-800 border-yellow-200 py-2 rounded font-bold border">Menunggu</div>
                    @elseif($status == 'diproses')
                        <div class="bg-blue-100 text-blue-800 border-blue-200 py-2 rounded font-bold border">Diproses</div>
                    @elseif($status == 'selesai')
                        <div class="bg-green-100 text-green-800 border-green-200 py-2 rounded font-bold border">Selesai</div>
                    @elseif($status == 'ditolak')
                        <div class="bg-red-100 text-red-800 border-red-200 py-2 rounded font-bold border">Ditolak</div>
                    @endif
                </div>

                {{-- 
                    LOGIKA TAMPILAN:
                    1. Jika Selesai -> Tampilkan Tombol Download.
                    2. Jika Ditolak -> Tampilkan Alasan.
                    3. Jika Lainnya -> Tampilkan Form Edit.
                --}}

                @if($status == 'selesai')
                    {{-- Tampilan SUDAH SELESAI --}}
                    <div class="pt-4 border-t text-center">
                        <p class="text-sm font-bold text-gray-700 mb-2">Surat Resmi Terbit:</p>
                        <a href="{{ asset('storage/surat_jadi/' . $surat->file_surat) }}" target="_blank" class="block w-full text-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-bold transition shadow">
                            Download PDF
                        </a>
                        <p class="text-xs text-gray-400 mt-2">Surat tidak dapat diedit lagi.</p>
                    </div>

                @elseif($status == 'ditolak')
                    {{-- Tampilan DITOLAK --}}
                    <div class="bg-red-50 border border-red-100 p-4 rounded-lg text-center">
                        <p class="font-bold text-red-700 mb-1">Surat Ditolak</p>
                        <p class="text-sm text-red-600">"{{ $surat->pesan_admin ?? 'Tidak ada alasan' }}"</p>
                    </div>

                @else
                    {{-- Tampilan FORM (Masih Proses) --}}
                    <form action="{{ route('admin.surat.update', $surat->id) }}" method="POST" x-data="{ status: '' }">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Update Status:</label>
                            <select name="status" x-model="status" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500" required>
                                <option value="" disabled selected>-- Pilih Aksi --</option>
                                <option value="diproses">Proses (Sedang Dibuat)</option>
                                <option value="selesai">Selesai (Setujui)</option>
                                <option value="ditolak">Tolak Permohonan</option>
                            </select>
                        </div>

                        <div x-show="status == 'ditolak'" class="mb-4" style="display: none;">
                            <label class="block text-sm font-bold text-red-600 mb-2">Alasan Penolakan <span class="text-red-500">*</span></label>
                            <textarea name="alasan_penolakan" rows="3" class="w-full rounded-lg border-red-300 focus:ring-red-500" placeholder="Jelaskan alasan penolakan..."></textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg shadow transition mt-2">
                            Simpan Keputusan
                        </button>
                    </form>
                @endif

            </div>
        </div>

    </div>
</div>
@endsection