<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keluhan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KeluhanController extends Controller
{
    public function index()
    {
        $keluhans = Keluhan::with('user')->latest()->paginate(10);
        return view('admin.keluhan.index', compact('keluhans'));
    }

    public function show($id)
    {
        $keluhan = Keluhan::with('user')->findOrFail($id);
        return view('admin.keluhan.show', compact('keluhan'));
    }

    public function update(Request $request, $id)
    {
        $keluhan = Keluhan::with('user')->findOrFail($id);

        // 🔒 [LOGIC LOCK]
        // Prevent update if already 'selesai'
        if ($keluhan->status == 'selesai') {
            return back()->with('error', '⛔ Laporan ini sudah Selesai dan tidak dapat diubah lagi.');
        }

        $request->validate([
            // Ensure these match your database enum exactly
            'status' => 'required|in:menunggu,pending,diproses,proses,selesai,ditolak', 
        ]);

        // Normalize status values if necessary (e.g., pending -> menunggu)
        $newStatus = $request->status;
        if ($newStatus == 'pending') $newStatus = 'menunggu';
        if ($newStatus == 'proses') $newStatus = 'diproses';

        $keluhan->update([
            'status' => $newStatus,
        ]);

        // Activity Log
        $namaWarga = $keluhan->user->name ?? 'Warga';
        $statusStr = ucfirst($newStatus);
        LogAktivitas::catat("Merespon keluhan '{$keluhan->judul}' milik $namaWarga menjadi status: $statusStr");

        return redirect()->route('admin.keluhan.show', $id)->with('success', 'Status laporan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $keluhan = Keluhan::with('user')->findOrFail($id);
        $judulLama = $keluhan->judul;
        $namaWarga = $keluhan->user->name ?? 'Warga';

        if ($keluhan->foto_bukti) {
            $path = public_path('uploads/keluhan/' . $keluhan->foto_bukti);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $keluhan->delete();

        LogAktivitas::catat("Menghapus data keluhan '{$judulLama}' milik $namaWarga");

        return redirect()->route('admin.keluhan.index')->with('success', 'Laporan keluhan berhasil dihapus.');
    }
}