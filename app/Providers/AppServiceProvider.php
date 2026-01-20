<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <--- Tambahkan ini
use App\Models\Surat;   // <--- Panggil Model Surat
use App\Models\Keluhan; // <--- Panggil Model Keluhan

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
    {
        View::composer('*', function ($view) {
            
            // 1. Hitung Surat Menunggu per JENIS (Group By)
            // Hasilnya array: ['Surat Keterangan Tidak Mampu' => 2, 'Surat Domisili' => 1]
            $notifPerJenis = Surat::where('status', 'menunggu')
                ->selectRaw('jenis_surat, count(*) as total')
                ->groupBy('jenis_surat')
                ->pluck('total', 'jenis_surat')
                ->toArray();

            // 2. Hitung Total Semua (Opsional, buat jaga-jaga)
            $totalSurat = array_sum($notifPerJenis);

            // 3. Hitung Keluhan
            $notifKeluhan = Keluhan::where('status', 'menunggu')->count();

            // Kirim variabel ke View
            $view->with('notifPerJenis', $notifPerJenis); // <--- INI YANG PENTING
            $view->with('totalSurat', $totalSurat);
            $view->with('notifKeluhan', $notifKeluhan);
        });
    }
}