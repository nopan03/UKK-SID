<?php

namespace App\Http\Controllers\Admin; // Namespace harus benar (Admin)

use App\Http\Controllers\Controller;
use App\Models\LogAktivitas; // Import Model LogAktivitas
use Illuminate\Http\Request;

class LogAktivitasController extends Controller // Turunan dari Controller, bukan Model
{
    public function index()
    {
        // Ambil data log terbaru
        // Pastikan model LogAktivitas sudah ada dan benar
        $logs = LogAktivitas::with('user')->orderBy('waktu', 'desc')->paginate(20);
        
        return view('admin.log.index', compact('logs'));
    }
}