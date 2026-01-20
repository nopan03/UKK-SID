<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_keterangan_tidak_mampu', function (Blueprint $table) {
            $table->id();

            // 🔥 PERBAIKAN: Ganti integer jadi unsignedBigInteger
            $table->unsignedBigInteger('surat_id')->nullable()->index('surat_id');
            $table->unsignedBigInteger('biodata_id')->nullable()->index('biodata_id');
            
            $table->text('keperluan')->nullable();
            $table->timestamps();
            $table->text('keterangan_ekonomi')->nullable();
            $table->string('nomor_sk_tm')->nullable();
            $table->string('file_ktp')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_pengantar')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_tidak_mampu');
    }
};
