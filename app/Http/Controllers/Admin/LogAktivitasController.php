<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Kreait\Firebase\Factory;
use Illuminate\Http\Request;

class LogAktivitasController extends Controller
{
    public function index()
    {
        try {
            // 1. Koneksi Firebase
            $factory = (new \Kreait\Firebase\Factory)
                ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));
            
            $database = $factory->createDatabase();

            // 2. Ambil Semua Data (Tanpa Filter Aneh-aneh)
            $logsRaw = $database->getReference('logs')->getValue();

            // 3. Ubah ke Collection Laravel & Urutkan di Sini
            // sortByDesc('waktu') artinya: Yang waktunya paling baru, taruh di atas.
            $logs = collect($logsRaw ?? [])->sortByDesc('waktu');

        } catch (\Exception $e) {
            // Jika error, biarkan kosong (jangan mati aplikasinya)
            $logs = collect([]);
        }

        // 4. Kirim ke View
        return view('admin.log.index', compact('logs'));
    }
}