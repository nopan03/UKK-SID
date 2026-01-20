<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\LogAktivitas; 

// MODEL DETAIL SURAT
use App\Models\SuratKeteranganDomisili;
use App\Models\SuratKeteranganTidakMampu;
use App\Models\SuratPengantarSkck;
use App\Models\SuratKeteranganKelahiran;
use App\Models\SuratKeteranganKematian;
use App\Models\SuratKeteranganPindah;
use App\Models\SuratPengantarNikah;
use App\Models\SuratPengajuanTanah;
use App\Models\SuratKeteranganUsaha;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SuratController extends Controller
{
    /**
     * 1. RIWAYAT SURAT & HAPUS NOTIFIKASI
     */
    public function index()
    {
        $userId = Auth::id();

        // Update status 'read' hanya untuk surat yang sudah selesai/ditolak
        Surat::where('user_id', $userId)
            ->whereIn('status', ['selesai', 'Selesai', 'SELESAI', 'ditolak', 'Ditolak', 'DITOLAK']) 
            ->where(function($query) {
                $query->where('is_read', 0)
                      ->orWhereNull('is_read');
            })
            ->update(['is_read' => 1]); 

        // Ambil data riwayat surat
        $suratSaya = Surat::where('user_id', $userId)
                        ->latest()
                        ->paginate(10);

        return view('warga.riwayat', compact('suratSaya'));
    }

    /**
     * 2. TAMPILKAN FORM PENGAJUAN
     */
    public function create($jenis)
    {
        $jenis_decoded = urldecode($jenis);
        return view('warga.surat.create', [
            'jenis' => $jenis_decoded,
        ]);
    }

    /**
     * 3. PROSES SIMPAN (STORE)
     */
    public function store(Request $request)
    {
        // A. VALIDASI INPUT
        $request->validate([
            'jenis_surat' => 'required',
            'keperluan'   => 'required|string',

            // Validasi Khusus SKTM
            'penghasilan' => 'nullable|numeric',
            'tanggungan'  => 'nullable|numeric',

            // --- VALIDASI SURAT NIKAH (LENGKAP) ---
            'nama_pasangan'              => 'nullable|string',
            'nik_pasangan'               => 'nullable|numeric|digits:16',
            'tempat_lahir_pasangan'      => 'nullable|string',
            'tanggal_lahir_pasangan' => 'nullable|date|after:1900-01-01|before:tomorrow',
            'agama_pasangan'             => 'nullable|string',
            'pekerjaan_pasangan'         => 'nullable|string',
            'alamat_pasangan'            => 'nullable|string',
            'status_perkawinan_pasangan' => 'nullable|string',
            'tanggal_nikah' => 'nullable|date|after:1900-01-01|before:9999-12-31',
            'lokasi_nikah'               => 'nullable|string',

            // Validasi File (Limit 2MB)
            'file_ktp'          => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_kk'           => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_pengantar'    => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_akta'         => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_buku_nikah'   => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_ket_lahir'    => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_ket_kematian' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_bukti_usaha'  => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_ktp_almarhum' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_kk_almarhum'  => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_ktp_pasangan' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_bukti_tanah'  => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'file_pbb'          => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $biodataId     = optional(Auth::user()->biodata)->id;
            $jenisSurat    = $request->jenis_surat;
            $keperluanUmum = $request->keperluan; 

            // B. SIMPAN SURAT UTAMA (Header)
            $surat = Surat::create([
                'user_id'     => Auth::id(),
                'jenis_surat' => $jenisSurat,
                'status'      => 'menunggu',
                'keterangan'  => $keperluanUmum,
                'is_read'     => false, 
            ]);

            // C. FUNGSI UPLOAD FILE
            $uploadFile = function ($inputName, $folderName) use ($request) {
                if ($request->hasFile($inputName)) {
                    if (!Storage::disk('public')->exists($folderName)) {
                        Storage::disk('public')->makeDirectory($folderName);
                    }
                    $file = $request->file($inputName);
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    return $file->storeAs($folderName, $filename, 'public');
                }
                return null;
            };

            // D. SIMPAN DETAIL SESUAI JENIS SURAT
            switch ($jenisSurat) {

                // 1. SKTM
                case 'Surat Keterangan Tidak Mampu':
                    $infoEkonomi = '-';
                    if ($request->penghasilan || $request->tanggungan) {
                        $infoEkonomi = "Penghasilan: Rp " . number_format((float) $request->penghasilan, 0, ',', '.')
                                     . ", Tanggungan: " . ($request->tanggungan ?? 0) . " Orang.";
                    }

                    SuratKeteranganTidakMampu::create([
                        'surat_id'           => $surat->id,
                        'biodata_id'         => $biodataId,
                        'keperluan'          => $keperluanUmum,
                        'keterangan_ekonomi' => $infoEkonomi,
                        'file_ktp'           => $uploadFile('file_ktp', 'ktp'),
                        'file_kk'            => $uploadFile('file_kk', 'kk'),
                        'file_pengantar'     => $uploadFile('file_pengantar', 'surat_pengantar'),
                    ]);
                    break;

                // 2. SK USAHA
                case 'Surat Keterangan Usaha':
                    SuratKeteranganUsaha::create([
                        'surat_id'         => $surat->id,
                        'biodata_id'       => $biodataId,
                        'nama_usaha'       => $request->nama_usaha,
                        'jenis_usaha'      => $request->jenis_usaha,
                        'alamat_usaha'     => $request->alamat_usaha,
                        'lama_usaha'       => $request->lama_usaha,
                        'file_ktp'         => $uploadFile('file_ktp', 'ktp'),
                        'file_bukti_usaha' => $uploadFile('file_bukti_usaha', 'bukti_usaha'),
                    ]);
                    break;

                // 3. DOMISILI
                case 'Surat Keterangan Domisili':
                    SuratKeteranganDomisili::create([
                        'surat_id'   => $surat->id,
                        'biodata_id' => $biodataId,
                        'keperluan'  => $keperluanUmum,
                        'file_ktp'   => $uploadFile('file_ktp', 'ktp'),
                        'file_kk'    => $uploadFile('file_kk', 'kk'),
                    ]);
                    break;

                // 4. SKCK
                case 'Surat Pengantar SKCK':
                    SuratPengantarSkck::create([
                        'surat_id'       => $surat->id,
                        'biodata_id'     => $biodataId,
                        'keperluan'      => $keperluanUmum,
                        'file_ktp'       => $uploadFile('file_ktp', 'ktp'),
                        'file_kk'        => $uploadFile('file_kk', 'kk'),
                        'file_akta'      => $uploadFile('file_akta', 'akta_kelahiran'),
                        'file_pengantar' => $uploadFile('file_pengantar', 'surat_pengantar'),
                    ]);
                    break;

                // 5. KELAHIRAN
                case 'Surat Keterangan Kelahiran':
                    SuratKeteranganKelahiran::create([
                        'surat_id'           => $surat->id,
                        'nama_bayi'          => $request->nama_bayi,
                        'tanggal_lahir_bayi' => $request->tanggal_lahir_bayi ?? now(),
                        'jenis_kelamin_bayi' => $request->jenis_kelamin_bayi ?? 'Laki-laki',
                        'ayah_id'            => $request->ayah_id,
                        'ibu_id'             => $request->ibu_id,
                        'file_ktp_lahir'     => $uploadFile('file_ket_lahir', 'surat_ket_lahir'),
                        'file_kk_lahir'      => $uploadFile('file_kk', 'kk'),
                        'file_buku_nikah'    => $uploadFile('file_buku_nikah', 'buku_nikah'),
                    ]);
                    break;

                // 6. KEMATIAN
                case 'Surat Keterangan Kematian':
                    SuratKeteranganKematian::create([
                        'surat_id'          => $surat->id,
                        'biodata_id'        => $biodataId,
                        'tanggal_wafat'     => $request->tgl_meninggal ?? now(),
                        'tempat_wafat'      => $request->tempat_wafat ?? '-',
                        'penyebab_wafat'    => $request->penyebab_wafat ?? '-',
                        'pelapor_id'        => Auth::id(),
                        'file_ktp_almarhum' => $uploadFile('file_ktp_almarhum', 'ktp'),
                        'file_kk_almarhum'  => $uploadFile('file_kk_almarhum', 'kk'),
                        'file_ket_kematian' => $uploadFile('file_ket_kematian', 'surat_ket_kematian'),
                    ]);
                    break;

                // 7. PINDAH
                case 'Surat Keterangan Pindah':
                    SuratKeteranganPindah::create([
                        'surat_id'       => $surat->id,
                        'biodata_id'     => $biodataId,
                        'alamat_asal'    => $request->alamat_asal,
                        'alamat_tujuan'  => $request->alamat_tujuan,
                        'alasan_pindah'  => $request->alasan_pindah,
                        'file_ktp'       => $uploadFile('file_ktp', 'ktp'),
                        'file_kk'        => $uploadFile('file_kk', 'kk'),
                        'file_pengantar' => $uploadFile('file_pengantar', 'surat_pengantar'),
                    ]);
                    break;

               // 8. SURAT PENGANTAR NIKAH (YANG SUDAH DIPERBAIKI LENGKAP)
                case 'Surat Pengantar Nikah':
                    
                    // Cek Gender User yang login
                    $genderUser = optional(Auth::user()->biodata)->jenis_kelamin;
                    $nikUser    = optional(Auth::user()->biodata)->nik;

                    // Siapkan Data untuk Disimpan
                    $dataNikah = [
                        'surat_id' => $surat->id,
                        
                        // 🔥 DATA RENCANA PERNIKAHAN 🔥
                        'tanggal_nikah' => $request->tanggal_nikah, 
                        'lokasi_nikah'  => $request->lokasi_nikah,

                        // 🔥 DATA PASANGAN (LENGKAP) 🔥
                        'nama_pasangan'              => $request->nama_pasangan,
                        'tempat_lahir_pasangan'      => $request->tempat_lahir_pasangan,
                        'tanggal_lahir_pasangan'     => $request->tanggal_lahir_pasangan,
                        'agama_pasangan'             => $request->agama_pasangan,
                        'alamat_pasangan'            => $request->alamat_pasangan,
                        'status_perkawinan_pasangan' => $request->status_perkawinan_pasangan,
                        'pekerjaan_pasangan'         => $request->pekerjaan_pasangan,

                        // File Upload
                        'file_ktp'          => $uploadFile('file_ktp', 'ktp'),
                        'file_kk'           => $uploadFile('file_kk', 'kk'),
                        'file_akta'         => $uploadFile('file_akta', 'akta_kelahiran'),
                        'file_ktp_pasangan' => $uploadFile('file_ktp_pasangan', 'ktp'),
                    ];

                    // LOGIKA: Tentukan Kolom NIK (Siapa Suami, Siapa Istri)
                    // Jika user Laki-laki atau 'L', maka user adalah Calon Suami
                    if ($genderUser == 'Laki-laki' || $genderUser == 'L') {
                        $dataNikah['pria_id']  = $biodataId;
                        $dataNikah['nik_pria'] = $nikUser;
                        $dataNikah['nik_wanita'] = $request->nik_pasangan; // Pasangan = Istri
                    } else {
                        // Jika user Perempuan, maka user adalah Calon Istri
                        $dataNikah['wanita_id']  = $biodataId;
                        $dataNikah['nik_wanita'] = $nikUser;
                        $dataNikah['nik_pria']   = $request->nik_pasangan; // Pasangan = Suami
                    }

                    SuratPengantarNikah::create($dataNikah);
                    break;

                // 9. TANAH
                case 'Surat Pengajuan Tanah':
                    SuratPengajuanTanah::create([
                        'surat_id'         => $surat->id,
                        'biodata_id'       => $biodataId,
                        'lokasi_tanah'     => $request->lokasi_tanah,
                        'luas_tanah'       => $request->luas_tanah,
                        'keperluan_tanah'  => $request->keperluan_tanah,
                        'file_ktp'         => $uploadFile('file_ktp', 'ktp'),
                        'file_kk'          => $uploadFile('file_kk', 'kk'),
                        'file_bukti_tanah' => $uploadFile('file_bukti_tanah', 'bukti_tanah'),
                        'file_pbb'         => $uploadFile('file_pbb', 'bukti_pbb'),
                    ]);
                    break;
            }

            LogAktivitas::catat("Mengajukan permohonan surat baru: $jenisSurat");

            DB::commit();

            return redirect()
                ->route('warga.riwayat')
                ->with('success', 'Pengajuan surat berhasil dikirim!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal mengirim pengajuan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * 4. DETAIL SURAT (View Warga)
     */
    public function show($id)
    {
        $surat = Surat::with(['user.biodata'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $detail = null;

        switch ($surat->jenis_surat) {
            case 'Surat Keterangan Tidak Mampu': $detail = $surat->detailTidakMampu; break;
            case 'Surat Keterangan Domisili':    $detail = $surat->detailDomisili; break;
            case 'Surat Keterangan Kelahiran':   $detail = $surat->detailKelahiran; break;
            case 'Surat Keterangan Kematian':    $detail = $surat->detailKematian; break;
            case 'Surat Pengantar Nikah':        $detail = $surat->detailNikah; break;
            case 'Surat Keterangan Pindah':      $detail = $surat->detailPindah; break;
            case 'Surat Pengajuan Tanah':        $detail = $surat->detailTanah; break;
            case 'Surat Pengantar SKCK':         $detail = $surat->detailSkck; break;
            case 'Surat Keterangan Usaha':       $detail = $surat->detailUsaha; break;
        }

        return view('warga.surat.show', compact('surat', 'detail'));
    }

    /**
     * Menampilkan Halaman Validasi (Publik)
     */
    public function validasi($id)
    {
        // Cari surat berdasarkan ID, sertakan data user dan biodata
        $surat = \App\Models\Surat::with(['user.biodata'])->findOrFail($id);

        // Tampilkan view validasi
        return view('warga.surat.validasi', compact('surat'));
    }
}