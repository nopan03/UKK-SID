<?php

namespace App\Http\Controllers\Admin; // <-- INI ALAMAT YANG BENAR

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin beserta data warga.
     */
    public function index()
    {
        $semua_warga = Penduduk::latest()->paginate(10);

        return view('admin.dashboard', ['warga' => $semua_warga]);
    }
}