<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Surat;
use App\Models\Berita;
use App\Models\LogAktivitas; 

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Statistik
        $totalWarga = User::where('role', 'warga')->count();
        $suratMenunggu = Surat::where('status', 'menunggu')->count();
        $totalBerita = Berita::count();

        // 2. Ambil Data Surat Masuk (Untuk Tabel)
        $suratMasuk = Surat::with('user')
                        ->where('status', 'menunggu')
                        ->latest()
                        ->take(5)
                        ->get();

        // 3. Ambil Log Aktivitas
        $logs = LogAktivitas::with('user')->latest('waktu')->take(5)->get();

        // 4. Kirim SEMUA ke View
        return view('admin.dashboard', compact(
            'totalWarga', 
            'suratMenunggu', 
            'totalBerita', 
            'suratMasuk', 
            'logs'
        ));
    }
}