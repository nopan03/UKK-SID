<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Surat;
use App\Models\Berita;
use App\Models\Keluhan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik
        $totalWarga = User::where('role', 'warga')->count();
        $suratMenunggu = Surat::where('status', 'menunggu')->count();
        $totalBerita = Berita::count();
        
        // 2. Surat Terbaru
        $suratTerbaru = Surat::with('user')->latest()->take(5)->get();

        // 3. Keluhan Terbaru
        // Kita masukkan semua kemungkinan status 'belum selesai'
        // (menunggu, pending, proses, diproses) agar data pasti muncul apapun tulisannya di DB.
        $keluhanTerbaru = Keluhan::with('user')
                            ->whereIn('status', ['menunggu', 'pending', 'proses', 'diproses']) 
                            ->latest()
                            ->take(3)
                            ->get();

        return view('admin.dashboard', compact(
            'totalWarga', 
            'suratMenunggu', 
            'totalBerita', 
            'suratTerbaru',
            'keluhanTerbaru'
        ));
    }
}