<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LaporDiri;
use App\Models\User;
use App\Models\LogAktivitas; // 🔥 Import Log
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerifikasiPendatangController extends Controller
{
    // Menampilkan daftar
    public function index()
    {
        $pendatang = LaporDiri::with('user')
                        ->orderByRaw("FIELD(status, 'menunggu', 'disetujui', 'ditolak')")
                        ->latest()
                        ->paginate(10);
                        
        return view('admin.pendatang.index', compact('pendatang'));
    }

    // Menampilkan detail
    public function show($id)
    {
        $pendatang = LaporDiri::with('user')->findOrFail($id);
        return view('admin.pendatang.show', compact('pendatang'));
    }

    // Proses ACC atau TOLAK
    public function update(Request $request, $id)
    {
        $laporan = LaporDiri::findOrFail($id);
        $user = User::findOrFail($laporan->user_id);

        if ($request->action == 'terima') {
            // 1. Update Status Laporan
            $laporan->update([
                'status' => 'disetujui',
                'pesan_admin' => 'Data Anda telah diverifikasi. Selamat datang!',
            ]);

            // 2. Ubah Role User jadi 'warga'
            $user->update(['role' => 'warga']);

            // 🔥 LOG ADMIN TERIMA 🔥
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Verifikasi Pendatang (Diterima)',
                'keterangan' => 'Admin menyetujui laporan dari: ' . $user->name . ' (' . $user->nik . ')',
            ]);

            return back()->with('success', 'Warga pendatang berhasil diverifikasi dan aktif.');

        } elseif ($request->action == 'tolak') {
            // Update Status Ditolak
            $laporan->update([
                'status' => 'ditolak',
                'pesan_admin' => $request->alasan ?? 'Data tidak valid.',
            ]);

            // 🔥 LOG ADMIN TOLAK 🔥
            LogAktivitas::create([
                'user_id' => Auth::id(),
                'aktivitas' => 'Verifikasi Pendatang (Ditolak)',
                'keterangan' => 'Admin menolak laporan dari: ' . $user->name . '. Alasan: ' . $request->alasan,
            ]);

            return back()->with('success', 'Pengajuan ditolak.');
        }
    }

    // Hapus Data
    public function destroy($id)
    {
        $laporan = LaporDiri::with('user')->findOrFail($id);
        $namaPelapor = $laporan->user->name ?? 'Unknown User';

        // Hapus file foto dari storage jika ada
        if ($laporan->foto_surat && Storage::disk('public')->exists($laporan->foto_surat)) {
            Storage::disk('public')->delete($laporan->foto_surat);
        }

        $laporan->delete();

        // 🔥 LOG ADMIN HAPUS 🔥
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Hapus Data Pendatang',
            'keterangan' => 'Admin menghapus data pengajuan milik: ' . $namaPelapor,
        ]);

        return back()->with('success', 'Data laporan berhasil dihapus.');
    }
}