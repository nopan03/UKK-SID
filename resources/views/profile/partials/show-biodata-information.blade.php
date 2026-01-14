<section class="bg-white shadow sm:rounded-lg p-4 sm:p-8">
    <header class="border-b pb-4 mb-4">
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Biodata Warga') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Informasi kependudukan Anda berdasarkan NIK yang terdaftar.
        </p>
    </header>

    @if($user->biodata)
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-bold text-gray-800 w-1/3 align-top">NIK</td>
                        <td class="py-3 font-mono text-gray-700">{{ $user->biodata->nik }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-bold text-gray-800 align-top">Nama Lengkap</td>
                        <td class="py-3">{{ $user->biodata->nama }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-bold text-gray-800 align-top">Tempat, Tgl Lahir</td>
                        <td class="py-3">
                            {{ $user->biodata->tempat_lahir }}, 
                            {{ \Carbon\Carbon::parse($user->biodata->tanggal_lahir)->translatedFormat('d F Y') }}
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-bold text-gray-800 align-top">Jenis Kelamin</td>
                        <td class="py-3">
                            @if($user->biodata->jenis_kelamin == 'L')
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">Laki-laki</span>
                            @else
                                <span class="bg-pink-100 text-pink-800 text-xs px-2 py-1 rounded-full font-bold">Perempuan</span>
                            @endif
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-bold text-gray-800 align-top">Alamat</td>
                        <td class="py-3">{{ $user->biodata->alamat }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-bold text-gray-800 align-top">Agama</td>
                        <td class="py-3">{{ $user->biodata->agama }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-bold text-gray-800 align-top">Status Perkawinan</td>
                        <td class="py-3">{{ $user->biodata->status_perkawinan }}</td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 font-bold text-gray-800 align-top">Pekerjaan</td>
                        <td class="py-3">{{ $user->biodata->pekerjaan }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex items-start p-4 bg-blue-50 text-blue-800 rounded-lg border border-blue-100 text-sm">
            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div>
                <p class="font-bold">Informasi Data:</p>
                <p>Data di atas bersifat <em>Read-Only</em> (Hanya Baca). Jika terdapat kesalahan penulisan nama, NIK, atau tanggal lahir, silakan hubungi Admin Desa di Balai Desa dengan membawa dokumen pendukung (KTP/KK).</p>
            </div>
        </div>
    @else
        {{-- TAMPILAN JIKA DATA TIDAK DITEMUKAN --}}
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm leading-5 font-medium text-yellow-800">
                        Biodata Belum Tersedia
                    </h3>
                    <div class="mt-2 text-sm leading-5 text-yellow-700">
                        <p>
                            Sistem tidak dapat menemukan data penduduk dengan NIK: <strong>{{ Auth::user()->nik }}</strong>.
                        </p>
                        <p class="mt-1">
                            Kemungkinan penyebab:
                            <ul class="list-disc list-inside ml-2">
                                <li>Admin belum menginput data biodata Anda.</li>
                                <li>NIK di akun Anda berbeda dengan NIK di data arsip desa.</li>
                            </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</section>