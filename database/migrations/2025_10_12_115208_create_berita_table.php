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
    Schema::create('berita', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->text('isi')->nullable();
        $table->string('kategori')->nullable();
        $table->date('tanggal')->nullable();
        
        // ▼▼ PASTIKAN BARIS INI SEPERTI INI ▼▼
        // Gunakan unsignedBigInteger agar cocok dengan tabel Users, 
        // tapi JANGAN tambahkan ->foreign(...) dulu biar aman.
        $table->unsignedBigInteger('user_id')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};