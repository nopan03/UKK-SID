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
            $table->integer('id', true);
            $table->integer('surat_id')->nullable()->index('surat_id');
            $table->integer('biodata_id')->nullable()->index('biodata_id');
            $table->text('keperluan')->nullable();
            $table->text('keterangan_ekonomi')->nullable();
            $table->string('nomor_sk_tm')->nullable();
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
