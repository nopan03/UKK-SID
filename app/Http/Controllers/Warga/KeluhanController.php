<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluhan;
use App\Models\LogAktivitas; // 🔥 IMPORT MODEL LOG
use Illuminate\Support\Facades\Auth;

class KeluhanController extends Controller
{
    public function create()
    {
        return view('warga.lapor.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_laporan' => 'required',
            'isi_laporan'   => 'required',
            'foto_bukti'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $nama_foto = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $cleanName = str_replace(' ', '_', $file->getClientOriginalName());
            $nama_foto = time() . '_' . $cleanName;
            $file->move(public_path('uploads/keluhan'), $nama_foto);
        }

        // Simpan Keluhan
        Keluhan::create([
            'user_id'    => Auth::id(),
            'judul'      => $request->judul_laporan,
            'isi'        => $request->isi_laporan,
            'foto_bukti' => $nama_foto,
            'status'     => 'menunggu'
        ]);

        LogAktivitas::catat('Warga melaporkan keluhan: ' . $request->judul_laporan);

        return redirect()->route('keluhan.create')->with('success', 'Laporan berhasil dikirim!');
    }
}