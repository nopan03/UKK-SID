<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_keterangan_usaha', function (Blueprint $table) {
            $table->id(); // Pengganti integer('id', true)

            // 🔥 PERBAIKAN: Ganti integer jadi unsignedBigInteger
            $table->unsignedBigInteger('surat_id')->nullable()->index('surat_id');
            $table->unsignedBigInteger('biodata_id')->nullable()->index('biodata_id');
            
            $table->string('nama_usaha')->nullable();
            $table->string('jenis_usaha')->nullable();
            $table->text('alamat_usaha')->nullable();
            $table->string('lama_usaha')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->timestamps();
            $table->string('file_ktp')->nullable();
            $table->string('file_bukti_usaha')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_usaha');
    }
};