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
        Schema::create('surat_keterangan_kelahiran', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('surat_id')->nullable()->index('surat_id');
            $table->string('nama_bayi')->nullable();
            $table->date('tanggal_lahir_bayi')->nullable();
            $table->enum('jenis_kelamin_bayi', ['L', 'P'])->nullable();
            $table->integer('ayah_id')->nullable()->index('ayah_id');
            $table->integer('ibu_id')->nullable()->index('ibu_id');
            $table->string('nomor_surat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_kelahiran');
    }
};
