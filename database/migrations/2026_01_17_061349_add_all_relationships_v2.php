<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // DAFTAR TABEL YANG PERLU DITAMBAHKAN RELASI KE 'surat'
        // CATATAN: 'surat_pengantar_nikah' TIDAK ADA DISINI KARENA SUDAH DIATUR DI FILE MIGRATIONNYA SENDIRI
        $tabelAnakSurat = [
            'surat_keterangan_domisili', 
            'surat_keterangan_usaha',
            'surat_keterangan_tidak_mampu', 
            'surat_keterangan_kelahiran',
            'surat_keterangan_kematian', 
            'surat_keterangan_pindah',
            'surat_pengajuan_tanah', 
            'surat_pengantar_skck',
        ];

        foreach ($tabelAnakSurat as $tabel) {
            if (Schema::hasTable($tabel)) {
                Schema::table($tabel, function (Blueprint $table) {
                    // Pastikan tipe data surat_id di tabel anak adalah unsignedBigInteger
                    // Jika belum ada index, laravel otomatis menambahkannya saat foreign key dibuat
                    $table->foreign('surat_id')
                          ->references('id')->on('surat')
                          ->onDelete('cascade');
                });
            }
        }

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        // Biarkan kosong
    }
};