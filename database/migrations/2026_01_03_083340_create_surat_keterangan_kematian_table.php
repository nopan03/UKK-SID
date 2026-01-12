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
        Schema::create('surat_keterangan_kematian', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('surat_id')->nullable()->index('surat_id');
            $table->integer('biodata_id')->nullable()->index('biodata_id');
            $table->date('tanggal_wafat')->nullable();
            $table->string('tempat_wafat')->nullable();
            $table->string('penyebab_wafat')->nullable();
            $table->integer('pelapor_id')->nullable()->index('pelapor_id');
            $table->string('nomor_surat')->nullable();
            $table->timestamps();
            $table->string('file_ket_kematian')->nullable();
            $table->string('file_ktp_almarhum')->nullable();
            $table->string('file_kk_almarhum')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_kematian');
    }
};
