<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\LogAktivitas; // 🔥 IMPORT MODEL LOG
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SuratController extends Controller
{
    /**
     * ===============================
     * 1. INDEX
     * ===============================
     */
    public function index(Request $request)
    {
        $query = Surat::with('user')->latest();

        if ($request->filled('jenis')) {
            $query->where('jenis_surat', $request->jenis);
        }

        if ($request->filled('status')) {
            $query->where('status', strtolower(trim($request->status)));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }

        $surats = $query->paginate(10);
        $surats->appends($request->all());

        return view('admin.surat.index', compact('surats'));
    }

    /**
     * ===============================
     * 2. SHOW
     * ===============================
     */
    public function show($id)
    {
        $surat = Surat::with(['user.biodata'])->findOrFail($id);

        // Ambil data detail (hasilnya object stdClass atau null)
        $detailRaw = $this->getDetailData($surat->jenis_surat, $id);

        // KONVERSI KE ARRAY AGAR VIEW AMAN
        $detail = $detailRaw ? (array) $detailRaw : null;

        return view('admin.surat.show', compact('surat', 'detail'));
    }

    /**
     * ===============================
     * 3. UPDATE STATUS (LOG AKTIVITAS DITAMBAHKAN DISINI)
     * ===============================
     */
    public function update(Request $request, $id)
    {
        $surat = Surat::with('user')->findOrFail($id);

        // 🔒 KUNCI JIKA SUDAH FINAL
        $statusRaw = strtolower(trim($surat->status));
        if (in_array($statusRaw, ['selesai', 'ditolak'])) {
            return redirect()
                ->back()
                ->with('error', '⛔ Surat sudah final dan tidak dapat diubah.');
        }

        // VALIDASI
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'alasan_penolakan' => 'required_if:status,ditolak|nullable|string',
        ]);

        $newStatus = strtolower(trim($request->status));

        $dataUpdate = [
            'status' => $newStatus,
            'pesan_admin' => null
        ];

        // === JIKA DITOLAK ===
        if ($newStatus === 'ditolak') {
            $dataUpdate['pesan_admin'] = $request->alasan_penolakan;
        }

        // === JIKA SELESAI ===
        if ($newStatus === 'selesai') {

            $detailRaw = $this->getDetailData($surat->jenis_surat, $id);
            $detail = $detailRaw ? (array) $detailRaw : null;

            // Nomor Surat
            $nomorSurat = $this->getNomorFromDetail($surat->jenis_surat, $detailRaw);
            
            if (!$nomorSurat) {
                $nomorSurat = $this->generateNomorSurat($surat->jenis_surat);
                $this->setNomorToDetail($surat->jenis_surat, $id, $nomorSurat);
                
                // Refresh data detail setelah update nomor
                $detailRaw = $this->getDetailData($surat->jenis_surat, $id);
                $detail = (array) $detailRaw;
            }

            $dataUpdate['nomor_surat'] = $nomorSurat;

            // QR
            $qrText = "SURAT: {$surat->jenis_surat}\nNO: {$nomorSurat}\nID: {$surat->id}";
            $qrSvg = QrCode::format('svg')->size(120)->margin(1)->generate($qrText);
            $qrBase64 = base64_encode($qrSvg);

            // PDF
            $pdf = Pdf::loadView('admin.surat.pdf', [
                'surat'    => $surat,
                'detail'   => $detail,
                'noSurat'  => $nomorSurat,
                'qrBase64' => $qrBase64,
            ]);

            Storage::disk('public')->makeDirectory('surat_jadi');
            $filename = time() . '_SURAT_' . $surat->id . '.pdf';
            Storage::disk('public')->put('surat_jadi/' . $filename, $pdf->output());

            $dataUpdate['file_surat'] = $filename;
        }

        // Simpan Perubahan
        $surat->update($dataUpdate);
        
        // ============================================================
        // 🔥 [LOG ACTIVITY START] MENCATAT AKTIVITAS ADMIN
        // ============================================================
        $namaWarga = $surat->user->name;
        $jenisSurat = $surat->jenis_surat;
        $pesanLog = "";

        if ($newStatus == 'selesai') {
            $pesanLog = "Menyetujui & Menerbitkan $jenisSurat untuk warga: $namaWarga";
        } elseif ($newStatus == 'ditolak') {
            $pesanLog = "Menolak permohonan $jenisSurat milik: $namaWarga";
        } elseif ($newStatus == 'diproses') {
            $pesanLog = "Memproses permohonan $jenisSurat milik: $namaWarga";
        }

        if ($pesanLog) {
            LogAktivitas::catat($pesanLog);
        }
        // ============================================================
        // 🔥 [LOG ACTIVITY END]
        // ============================================================

        return redirect()
            ->route('admin.surat.show', $id)
            ->with('success', 'Status surat berhasil diperbarui!');
    }

    /**
     * ===============================
     * 4. CETAK PDF
     * ===============================
     */
    public function cetakPdf(Surat $surat)
    {
        if (strtolower(trim($surat->status)) !== 'selesai') {
            abort(403, 'Surat belum selesai.');
        }

        $detailRaw = $this->getDetailData($surat->jenis_surat, $surat->id);
        $detail = $detailRaw ? (array) $detailRaw : null;

        $qrText = "SURAT: {$surat->jenis_surat}\nNO: {$surat->nomor_surat}\nID: {$surat->id}";
        $qrSvg = QrCode::format('svg')->size(120)->margin(1)->generate($qrText);
        $qrBase64 = base64_encode($qrSvg);

        $pdf = Pdf::loadView('admin.surat.pdf', [
            'surat'    => $surat,
            'detail'   => $detail,
            'noSurat'  => $surat->nomor_surat,
            'qrBase64' => $qrBase64,
        ]);

        return $pdf->stream('SURAT_' . $surat->id . '.pdf');
    }

    /**
     * ===============================
     * HELPER
     * ===============================
     */
    private function getDetailData($jenisSurat, $id)
    {
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

    private function getNomorFromDetail($jenisSurat, $detail)
    {
        if (!$detail) return null;
        return $detail->nomor_surat ?? $detail->nomor_sk_tm ?? null;
    }

    private function setNomorToDetail($jenisSurat, $id, $nomor)
    {
        $map = [
            'Surat Keterangan Tidak Mampu' => ['table' => 'surat_keterangan_tidak_mampu', 'field' => 'nomor_sk_tm'],
            'Surat Keterangan Usaha'       => ['table' => 'surat_keterangan_usaha', 'field' => 'nomor_surat'],
            'Surat Keterangan Domisili'    => ['table' => 'surat_keterangan_domisili', 'field' => 'nomor_surat'],
            'Surat Pengantar SKCK'         => ['table' => 'surat_pengantar_skck', 'field' => 'nomor_surat'],
            'Surat Keterangan Kelahiran'   => ['table' => 'surat_keterangan_kelahiran', 'field' => 'nomor_surat'],
            'Surat Keterangan Kematian'    => ['table' => 'surat_keterangan_kematian', 'field' => 'nomor_surat'],
            'Surat Keterangan Pindah'      => ['table' => 'surat_keterangan_pindah', 'field' => 'nomor_surat'],
            'Surat Pengantar Nikah'        => ['table' => 'surat_pengantar_nikah', 'field' => 'nomor_surat'],
            'Surat Pengajuan Tanah'        => ['table' => 'surat_pengajuan_tanah', 'field' => 'nomor_surat'],
        ];

        if (!isset($map[$jenisSurat])) return;

        DB::table($map[$jenisSurat]['table'])
            ->where('surat_id', $id)
            ->update([$map[$jenisSurat]['field'] => $nomor]);
    }

    private function generateNomorSurat($jenisSurat)
    {
        $now = Carbon::now();
        $urut = str_pad(
            Surat::whereYear('created_at', $now->year)
                ->whereMonth('created_at', $now->month)
                ->count() + 1,
            3,
            '0',
            STR_PAD_LEFT
        );

        $kode = match ($jenisSurat) {
            'Surat Keterangan Domisili'    => 'SKD',
            'Surat Keterangan Usaha'       => 'SKU',
            'Surat Keterangan Tidak Mampu' => 'SKTM',
            'Surat Keterangan Kelahiran'   => 'SKL',
            'Surat Keterangan Kematian'    => 'SKK',
            'Surat Keterangan Pindah'      => 'SKP',
            'Surat Pengantar SKCK'         => 'SKCK',
            'Surat Pengantar Nikah'        => 'SPN',
            'Surat Pengajuan Tanah'        => 'SPT',
            default                        => 'SK',
        };

        return "{$urut}/{$kode}/DS/" . $this->toRoman($now->month) . "/{$now->year}";
    }

    private function toRoman($month)
    {
        return [1=>'I',2=>'II',3=>'III',4=>'IV',5=>'V',6=>'VI',7=>'VII',8=>'VIII',9=>'IX',10=>'X',11=>'XI',12=>'XII'][$month];
    }
}