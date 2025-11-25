<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Keluhan; // Panggil Model tadi

class KeluhanController extends Controller
{
    // Fungsi 1: Menampilkan Halaman Form
    public function create()
    {
        return view('warga.lapor.create');
    }

    // Fungsi 2: Menyimpan Data ke Database
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'nama_pelapor' => 'required',
            'judul_laporan' => 'required',
            'isi_laporan' => 'required',
            'foto_bukti' => 'image|max:2048' // Opsional, maks 2MB
        ]);

        // Upload Foto (Jika ada)
        $nama_foto = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $nama_foto = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/keluhan'), $nama_foto);
        }

        // Simpan
        Keluhan::create([
            'nama_pelapor' => $request->nama_pelapor,
            'judul_laporan' => $request->judul_laporan,
            'isi_laporan' => $request->isi_laporan,
            'foto_bukti' => $nama_foto,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil dikirim!');
    }
}