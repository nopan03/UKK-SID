<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('surat_pengantar_nikah', function (Blueprint $table) {
            $table->id(); 
            
            // Relasi ke tabel induk 'surat' (Sudah benar pakai foreignId)
            $table->foreignId('surat_id')->constrained('surat')->onDelete('cascade');
            
            // Data Pria & Wanita
            $table->foreignId('pria_id')->nullable(); // Asumsi user/biodata id juga BigInteger
            $table->string('nik_pria')->nullable();
            $table->foreignId('wanita_id')->nullable(); // Asumsi user/biodata id juga BigInteger
            $table->string('nik_wanita')->nullable();
            
            // Data Pasangan Manual
            $table->string('nama_pasangan')->nullable();
            $table->string('tempat_lahir_pasangan')->nullable();
            $table->date('tanggal_lahir_pasangan')->nullable();
            $table->string('agama_pasangan')->nullable();
            $table->text('alamat_pasangan')->nullable();
            $table->string('status_perkawinan_pasangan')->nullable();
            $table->string('pekerjaan_pasangan')->nullable();

            // Kolom Lainnya
            $table->date('tanggal_nikah')->nullable();
            $table->string('lokasi_nikah')->nullable();
            
            // File Upload
            $table->string('file_ktp')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_akta')->nullable();
            $table->string('file_ktp_pasangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengantar_nikah');
    }
};