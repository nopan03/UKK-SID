<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Penduduk;

class PendudukController extends Controller
{
    public function index()
    {
        // Hitung total
        $totalPenduduk   = Penduduk::count();
        $totalLaki       = Penduduk::where('jenis_kelamin', 'L')->count();
        $totalPerempuan  = Penduduk::where('jenis_kelamin', 'P')->count();

        // Grafik pekerjaan
        $pekerjaan = Penduduk::select('pekerjaan', DB::raw('COUNT(*) as total'))
                            ->groupBy('pekerjaan')
                            ->get();

        $labelPekerjaan = $pekerjaan->pluck('pekerjaan');
        $dataPekerjaan  = $pekerjaan->pluck('total');

        return view('warga.infografis.penduduk', compact(
            'totalPenduduk',
            'totalLaki',
            'totalPerempuan',
            'labelPekerjaan',
            'dataPekerjaan'
        ));
    }
}