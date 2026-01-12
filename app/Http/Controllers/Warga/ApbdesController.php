<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KeuanganDesa;
use Illuminate\Support\Facades\DB;

class ApbdesController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Pemasukan (SEMUA TAHUN)
        // Kita hapus 'whereYear' agar angkanya sama dengan Admin
        $totalPemasukan = KeuanganDesa::where('jenis', 'pemasukan')
                            ->sum('jumlah'); 

        // 2. Hitung Total Pengeluaran (SEMUA TAHUN)
        $totalPengeluaran = KeuanganDesa::where('jenis', 'pengeluaran')
                            ->sum('jumlah');

        // Hitung Sisa Saldo
        $sisaAnggaran = $totalPemasukan - $totalPengeluaran;

        // 3. Data Grafik: Pemasukan per Kategori (SEMUA TAHUN)
        $grafikPemasukan = KeuanganDesa::select('kategori', DB::raw('SUM(jumlah) as total'))
                            ->where('jenis', 'pemasukan')
                            ->groupBy('kategori')
                            ->get();

        $labelMasuk = $grafikPemasukan->pluck('kategori');
        $dataMasuk  = $grafikPemasukan->pluck('total');

        // 4. Data Grafik: Pengeluaran per Kategori (SEMUA TAHUN)
        $grafikPengeluaran = KeuanganDesa::select('kategori', DB::raw('SUM(jumlah) as total'))
                            ->where('jenis', 'pengeluaran')
                            ->groupBy('kategori')
                            ->get();

        $labelKeluar = $grafikPengeluaran->pluck('kategori');
        $dataKeluar  = $grafikPengeluaran->pluck('total');

        // 5. Tabel Rincian (10 Transaksi Terakhir)
        $transaksiTerbaru = KeuanganDesa::latest('tanggal')->take(10)->get();

        return view('warga.infografis.apbdes', compact(
            'totalPemasukan', 'totalPengeluaran', 'sisaAnggaran',
            'labelMasuk', 'dataMasuk',
            'labelKeluar', 'dataKeluar',
            'transaksiTerbaru'
        ));
    }
}