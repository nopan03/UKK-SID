<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kreait\Firebase\Factory; // Import Library Firebase

class LogAktivitas extends Model
{
    use HasFactory;

    // Kita tidak butuh $fillable atau $table lagi karena tidak pakai MySQL.
    // Biarkan kosong atau default saja.

    /**
     * Fungsi Statis untuk Mencatat Log ke Firebase
     */
    public static function catat($aktivitas)
    {
        try {
            // 1. Koneksi ke Firebase
            // Pastikan path credential benar menggunakan base_path()
            $factory = (new Factory)
                ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
                ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

            $database = $factory->createDatabase();

            // 2. Siapkan Data
            $dataLog = [
                'aktivitas' => $aktivitas,
                'waktu'     => now()->toDateTimeString(), // Format: YYYY-MM-DD HH:mm:ss
                'user_id'   => auth()->id() ?? null,
                'user_name' => auth()->user()->name ?? 'Sistem',
                
                // Trik: Simpan timestamp negatif agar saat diambil nanti urutannya dari TERBARU ke TERLAMA
                // Karena Firebase aslinya mengurutkan dari kecil ke besar (Ascending)
                'timestamp' => time() * -1 
            ];

            // 3. Push (Kirim) ke "Folder" bernama 'logs' di Firebase
            $database->getReference('logs')->push($dataLog);

        } catch (\Exception $e) {
            // Jika internet mati atau Firebase error, biarkan saja (jangan bikin error 500)
            // Opsional: Log::error($e->getMessage());

            dd("ERROR SAAT AMBIL DATA: " . $e->getMessage());
        }
    }
}