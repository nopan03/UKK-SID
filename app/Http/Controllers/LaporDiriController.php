<?php

namespace App\Http\Controllers;

use App\Models\LaporDiri;
use App\Models\User;
use App\Models\LogAktivitas; // 🔥 Jangan lupa import ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LaporDiriController extends Controller
{
    // 1. Tampilkan Form Lapor
    public function index()
    {
        // Cek apakah user sudah pernah lapor
        $riwayat = LaporDiri::where('user_id', Auth::id())->latest()->first();
        return view('lapor.index', compact('riwayat'));
    }

    // 2. Simpan Laporan
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'agama' => 'required',
            'status_perkawinan' => 'required',
            'pekerjaan' => 'required',
            'alamat_asal' => 'required',
            'keperluan' => 'required',
            'foto_surat' => 'required|image|max:2048',
        ]);

        // Upload Gambar
        $path = $request->file('foto_surat')->store('uploads/surat_domisili', 'public');

        // Simpan ke Database
        LaporDiri::create([
            'user_id' => Auth::id(),
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'agama' => $request->agama,
            'status_perkawinan' => $request->status_perkawinan,
            'pekerjaan' => $request->pekerjaan,
            'alamat_asal' => $request->alamat_asal,
            'keperluan' => $request->keperluan,
            'foto_surat' => $path,
            'status' => 'menunggu', 
        ]);

        // 🔥 CATAT LOG AKTIVITAS (WARGA) 🔥
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aktivitas' => 'Mengirim Laporan Diri',
            'keterangan' => 'User ' . Auth::user()->name . ' mengirim biodata pendatang baru.',
        ]);

        return back()->with('success', 'Laporan berhasil dikirim! Mohon tunggu verifikasi Admin.');
    }
}