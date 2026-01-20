<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Dokumen - Desa Suruh</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f3f4f6; }
        .gradient-bg { background: linear-gradient(135deg, #166534 0%, #15803d 100%); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl overflow-hidden">
        
        {{-- HEADER --}}
        <div class="bg-white p-6 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <img src="{{ asset('img/SDA1.png') }}" alt="Logo" class="h-10 w-auto"> {{-- Pastikan logo ada --}}
                <div>
                    <h1 class="text-lg font-bold text-gray-800 leading-tight">Validasi Dokumen</h1>
                    <p class="text-xs text-gray-500">Pemerintah Desa Suruh</p>
                </div>
            </div>
        </div>

        <div class="p-6 space-y-6">

            {{-- STATUS --}}
            <div class="text-center">
                @if($surat->status == 'selesai')
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-green-50 text-green-700 border border-green-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm font-bold uppercase tracking-wide">Dokumen Valid & Asli</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Dokumen ini telah diverifikasi secara digital.</p>
                @else
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-red-50 text-red-700 border border-red-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span class="text-sm font-bold uppercase tracking-wide">Dokumen Tidak Valid</span>
                    </div>
                @endif
            </div>

            {{-- PROFIL INSTANSI --}}
            <div>
                <h3 class="flex items-center text-sm font-bold text-gray-900 mb-3">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Profil Instansi
                </h3>
                <div class="bg-gray-50 rounded-xl p-4 text-sm border border-gray-100">
                    <div class="grid grid-cols-2 gap-y-3">
                        <div>
                            <p class="text-xs text-gray-500">Nama Instansi</p>
                            <p class="font-semibold text-gray-800">Pemdes Suruh</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Kecamatan</p>
                            <p class="font-semibold text-gray-800">Sukodono</p> {{-- Sesuaikan --}}
                        </div>
                        <div class="col-span-2">
                            <p class="text-xs text-gray-500">Alamat</p>
                            <p class="font-semibold text-gray-800">Jl. Raya Suruh No. 1, Sidoarjo</p> {{-- Sesuaikan --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- DATA SURAT --}}
            <div>
                <h3 class="flex items-center text-sm font-bold text-gray-900 mb-3">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Detail Dokumen
                </h3>
                <div class="bg-gray-50 rounded-xl p-4 text-sm border border-gray-100">
                    <div class="grid grid-cols-1 gap-y-4">
                        <div>
                            <p class="text-xs text-gray-500">Jenis Surat</p>
                            <p class="font-bold text-green-700 text-base">{{ $surat->jenis_surat }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-gray-500">Nomor Surat</p>
                                <p class="font-semibold text-gray-800">{{ $surat->nomor_surat }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Tanggal Terbit</p>
                                <p class="font-semibold text-gray-800">{{ $surat->updated_at->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Nama Pemohon</p>
                            <p class="font-semibold text-gray-800">{{ $surat->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">NIK</p>
                            <p class="font-semibold text-gray-800">{{ $surat->user->biodata->nik ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TTD PEJABAT --}}
            <div>
                <h3 class="flex items-center text-sm font-bold text-gray-900 mb-3">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Penandatangan
                </h3>
                <div class="bg-gray-50 rounded-xl p-4 text-sm border border-gray-100 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500">Nama Pejabat</p>
                        <p class="font-semibold text-gray-800">Bpk. Kepala Desa</p> {{-- Bisa diganti variabel --}}
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 text-right">Jabatan</p>
                        <p class="font-semibold text-gray-800 text-right">Kepala Desa</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- FOOTER --}}
        <div class="bg-green-700 p-4 text-center">
            <p class="text-white text-xs opacity-90">&copy; {{ date('Y') }} Sistem Informasi Desa Suruh</p>
            <p class="text-white text-[10px] opacity-75 mt-1">Scan QR Code ini untuk memastikan keaslian dokumen.</p>
        </div>

    </div>

</body>
</html>