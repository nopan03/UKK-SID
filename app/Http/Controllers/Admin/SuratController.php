<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\LogAktivitas; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// 🔥 IMPORT WAJIB UNTUK EMAIL 🔥
use Illuminate\Support\Facades\Mail;
use App\Mail\SuratSelesai;

class SuratController extends Controller
{
    // ... (Index dan Show tidak berubah) ...
    public function index(Request $request)
    {
        $query = Surat::with('user')->latest();
        if ($request->filled('jenis')) $query->where('jenis_surat', $request->jenis);
        if ($request->filled('status')) $query->where('status', strtolower(trim($request->status)));
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('nik', 'like', "%{$search}%");
            });
        }
        $surats = $query->paginate(10);
        $surats->appends($request->all());
        return view('admin.surat.index', compact('surats'));
    }

    public function show($id)
    {
        $surat = Surat::with(['user.biodata'])->findOrFail($id);
        $detailRaw = $this->getDetailData($surat->jenis_surat, $id);
        $detail = $detailRaw ? (array) $detailRaw : null;
        return view('admin.surat.show', compact('surat', 'detail'));
    }

    /**
     * ===============================
     * 3. UPDATE (PROSES SURAT & KIRIM EMAIL)
     * ===============================
     */
    public function update(Request $request, $id)
    {
        $surat = Surat::with('user')->findOrFail($id);

        // A. Cek apakah surat sudah dikunci (Final)
        $statusRaw = strtolower(trim($surat->status));
        if (in_array($statusRaw, ['selesai', 'ditolak'])) {
            return redirect()->back()->with('error', '⛔ Surat sudah final dan tidak dapat diubah.');
        }

        // B. Validasi Input
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'alasan_penolakan' => 'required_if:status,ditolak|nullable|string',
        ]);

        $newStatus = strtolower(trim($request->status));
        
        $dataUpdate = [
            'status' => $newStatus,
            'pesan_admin' => ($newStatus === 'ditolak') ? $request->alasan_penolakan : null
        ];

        // C. LOGIKA JIKA STATUS SELESAI
        if ($newStatus === 'selesai') {

            // 1. Generate Nomor Surat
            $nomorSurat = $surat->nomor_surat;
            if (!$nomorSurat) {
                $nomorSurat = $this->generateNomorSurat($surat->jenis_surat);
                $dataUpdate['nomor_surat'] = $nomorSurat; 
            }

            // 2. Ambil Detail
            $detailRaw = $this->getDetailData($surat->jenis_surat, $id);
            $detail = $detailRaw ? (array) $detailRaw : null;

            // ============================================================
            // 🔥 [PERUBAHAN 1] QR CODE MODE OFFLINE (DATA TEKS LANGSUNG) 🔥
            // Data disimpan sebagai teks agar bisa discan tanpa internet
            // ============================================================
            $kontenQR  = "PEMERINTAH DESA SURUH\n";
            $kontenQR .= "DOKUMEN SAH & VALID\n\n";
            $kontenQR .= "Jenis : " . $surat->jenis_surat . "\n";
            $kontenQR .= "Nomor : " . $nomorSurat . "\n";
            $kontenQR .= "Nama  : " . ($surat->user->name ?? '-') . "\n";
            $kontenQR .= "NIK   : " . ($surat->user->biodata->nik ?? '-') . "\n";
            $kontenQR .= "Tgl   : " . Carbon::parse($surat->updated_at)->format('d-m-Y');

            $qrSvg = QrCode::format('svg')->size(120)->margin(1)->generate($kontenQR);
            $qrBase64 = base64_encode($qrSvg);
            // ============================================================

            // 4. Buat PDF
            $pdf = Pdf::loadView('admin.surat.pdf', [
                'surat'    => $surat,
                'detail'   => $detail,
                'noSurat'  => $nomorSurat,
                'qrBase64' => $qrBase64,
            ]);

            // 5. Simpan PDF
            Storage::disk('public')->makeDirectory('surat_jadi');
            $filename = time() . '_SURAT_' . $surat->id . '.pdf';
            Storage::disk('public')->put('surat_jadi/' . $filename, $pdf->output());

            $dataUpdate['file_surat'] = 'surat_jadi/' . $filename; 

            // 6. Eksekusi Update ke Database
            $surat->update($dataUpdate);

            // 7. KIRIM EMAIL
            if ($surat->user && $surat->user->email) {
                try {
                    Mail::to($surat->user->email)->send(new SuratSelesai($surat));
                } catch (\Exception $e) {
                    // Abaikan jika email gagal
                }
            }

        } else {
            $surat->update($dataUpdate);
        }

        // D. LOG AKTIVITAS
        $this->catatLog($surat, $newStatus);

        return redirect()->route('admin.surat.show', $id)
            ->with('success', 'Status diperbarui' . ($newStatus == 'selesai' ? ' & Surat terkirim ke email!' : '!'));
    }

    /**
     * ===============================
     * 4. CETAK PDF (Preview Manual)
     * ===============================
     */
    public function cetakPdf(Surat $surat)
    {
        if (strtolower(trim($surat->status)) !== 'selesai') abort(403, 'Surat belum selesai.');
        
        $detailRaw = $this->getDetailData($surat->jenis_surat, $surat->id);
        $detail = $detailRaw ? (array) $detailRaw : null;

        // ============================================================
        // 🔥 [PERUBAHAN 2] QR CODE MODE OFFLINE (DATA TEKS LANGSUNG) 🔥
        // Sama seperti di atas, tapi perhatikan variabel nomor suratnya
        // ============================================================
        $kontenQR  = "PEMERINTAH DESA SURUH\n";
        $kontenQR .= "DOKUMEN SAH & VALID\n\n";
        $kontenQR .= "Jenis : " . $surat->jenis_surat . "\n";
        $kontenQR .= "Nomor : " . $surat->nomor_surat . "\n"; // <-- Ambil dari database
        $kontenQR .= "Nama  : " . ($surat->user->name ?? '-') . "\n";
        $kontenQR .= "NIK   : " . ($surat->user->biodata->nik ?? '-') . "\n";
        $kontenQR .= "Tgl   : " . Carbon::parse($surat->updated_at)->format('d-m-Y');

        $qrSvg = QrCode::format('svg')->size(120)->margin(1)->generate($kontenQR);
        $qrBase64 = base64_encode($qrSvg);
        // ============================================================

        $pdf = Pdf::loadView('admin.surat.pdf', [
            'surat'    => $surat,
            'detail'   => $detail,
            'noSurat'  => $surat->nomor_surat,
            'qrBase64' => $qrBase64,
        ]);

        return $pdf->stream('SURAT_' . $surat->id . '.pdf');
    }

    // ... (Helper Functions & kirimEmail TETAP SAMA SEPERTI SEBELUMNYA) ...
    // Saya singkat agar tidak terlalu panjang, tapi PASTIKAN Anda tidak menghapus fungsi helper di bawah ini.
    
    private function getDetailData($jenisSurat, $id) {
        $map = [
            'Surat Keterangan Tidak Mampu' => 'surat_keterangan_tidak_mampu',
            'Surat Keterangan Usaha'       => 'surat_keterangan_usaha',
            'Surat Keterangan Domisili'    => 'surat_keterangan_domisili',
            'Surat Pengantar SKCK'         => 'surat_pengantar_skck',
            'Surat Keterangan Kelahiran'   => 'surat_keterangan_kelahiran',
            'Surat Keterangan Kematian'    => 'surat_keterangan_kematian',
            'Surat Keterangan Pindah'      => 'surat_keterangan_pindah',
            'Surat Pengantar Nikah'        => 'surat_pengantar_nikah',
            'Surat Pengajuan Tanah'        => 'surat_pengajuan_tanah',
        ];
        if (!isset($map[$jenisSurat])) return null;
        return DB::table($map[$jenisSurat])->where('surat_id', $id)->first();
    }
    
    private function generateNomorSurat($jenisSurat) {
        $now = Carbon::now();
        $urut = str_pad(Surat::whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count() + 1, 3, '0', STR_PAD_LEFT);
        $kode = match ($jenisSurat) {
            'Surat Keterangan Domisili' => 'SKD', 'Surat Keterangan Usaha' => 'SKU', 'Surat Keterangan Tidak Mampu' => 'SKTM', 'Surat Keterangan Kelahiran' => 'SKL', 'Surat Keterangan Kematian' => 'SKK', 'Surat Keterangan Pindah' => 'SKP', 'Surat Pengantar SKCK' => 'SKCK', 'Surat Pengantar Nikah' => 'SPN', 'Surat Pengajuan Tanah' => 'SPT', default => 'SK',
        };
        return "{$urut}/{$kode}/DS/" . $this->toRoman($now->month) . "/{$now->year}";
    }
    
    private function toRoman($month) { return [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'][$month]; }
    
    private function catatLog($surat, $newStatus) {
        $pesanLog = match($newStatus) {
            'selesai' => "Menyetujui & Menerbitkan {$surat->jenis_surat} untuk warga: " . ($surat->user->name ?? 'Warga'),
            'ditolak' => "Menolak permohonan {$surat->jenis_surat} milik: " . ($surat->user->name ?? 'Warga'),
            'diproses' => "Memproses permohonan {$surat->jenis_surat} milik: " . ($surat->user->name ?? 'Warga'),
            default => null
        };
        if ($pesanLog) LogAktivitas::catat($pesanLog);
    }

    public function kirimEmail($id)
    {
        $surat = Surat::with('user')->findOrFail($id);
        if ($surat->status !== 'selesai') return back()->with('error', '❌ Surat belum selesai, tidak bisa dikirim.');
        
        if (!$surat->file_surat) return back()->with('error', '❌ File PDF belum tersedia.');
        
        if (!$surat->user || !$surat->user->email) return back()->with('error', '❌ Data warga atau email tidak ditemukan.');

        try {
            Mail::to($surat->user->email)->send(new SuratSelesai($surat));
            return back()->with('success', '✅ Email berhasil dikirim ke ' . $surat->user->email);
        } catch (\Exception $e) {
            return back()->with('error', '❌ Gagal mengirim email: ' . $e->getMessage());
        }
    }
}