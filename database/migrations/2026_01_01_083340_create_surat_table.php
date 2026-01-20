<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // FILE MIGRATION INDUK (surat) YANG SUDAH DIPERBAIKI

public function up(): void
{
    Schema::create('surat', function (Blueprint $table) {
        // 🔥 GANTI BARIS INI 🔥
        // Hapus: $table->integer('id', true);
        
        // Ganti Menjadi:
        $table->id(); // Ini otomatis membuat Unsigned Big Integer (Cocok dengan foreignId)

        $table->integer('user_id')->nullable()->index('user_id');
        $table->dateTime('tanggal_pengajuan')->nullable();
        // ... sisa kolom lainnya tetap sama ...
        $table->enum('status', ['menunggu', 'diproses', 'selesai', 'ditolak'])->nullable()->default('menunggu');
        $table->string('nomor_surat')->nullable();
        $table->text('pesan_admin')->nullable();
        $table->string('file_surat')->nullable();
        $table->enum('jenis_surat', ['Surat Keterangan Tidak Mampu', 'Surat Pengantar Nikah', 'Surat Keterangan Pindah', 'Surat Pengajuan Tanah', 'Surat Keterangan Usaha', 'Surat Keterangan Domisili', 'Surat Keterangan Kelahiran', 'Surat Keterangan Kematian', 'Surat Pengantar SKCK']);
        $table->string('keterangan')->nullable();
        $table->dateTime('created_at')->nullable()->useCurrent();
        $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
