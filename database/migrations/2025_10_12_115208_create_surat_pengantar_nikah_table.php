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
        Schema::create('surat_pengantar_nikah', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('surat_id')->nullable()->index('surat_id');
            $table->integer('pria_id')->nullable()->index('pria_id');
            $table->string('nik_pria')->nullable();
            $table->integer('wanita_id')->nullable()->index('wanita_id');
            $table->string('nik_wanita')->nullable();
            $table->date('tanggal_nikah')->nullable();
            $table->string('lokasi_nikah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengantar_nikah');
    }
};
