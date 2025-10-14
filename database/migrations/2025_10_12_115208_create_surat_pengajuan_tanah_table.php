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
        Schema::create('surat_pengajuan_tanah', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('surat_id')->nullable()->index('surat_id');
            $table->integer('biodata_id')->nullable()->index('biodata_id');
            $table->text('lokasi_tanah')->nullable();
            $table->decimal('luas_tanah', 10)->nullable();
            $table->text('keperluan_tanah')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengajuan_tanah');
    }
};
