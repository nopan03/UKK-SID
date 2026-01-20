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
        $table->id();

        // 🔥 PERBAIKAN: Ganti integer jadi unsignedBigInteger
        $table->unsignedBigInteger('surat_id')->nullable()->index('surat_id');
        
        $table->string('nama_bayi')->nullable();
        $table->date('tanggal_lahir_bayi')->nullable();
        $table->enum('jenis_kelamin_bayi', ['L', 'P'])->nullable();
        
        // Asumsi Ayah/Ibu ambil dari tabel biodata/users yang pakai BigInteger
        $table->unsignedBigInteger('ayah_id')->nullable()->index('ayah_id');
        $table->unsignedBigInteger('ibu_id')->nullable()->index('ibu_id');
        
        $table->string('nomor_surat')->nullable();
        $table->timestamps();
        $table->string('file_ket_lahir')->nullable();
        $table->string('file_kk')->nullable();
        $table->string('file_buku_nikah')->nullable();
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
