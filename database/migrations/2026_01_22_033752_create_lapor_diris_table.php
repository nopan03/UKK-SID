<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('lapor_diris', function (Blueprint $table) {
            $table->id();
            
            // 🔥 PERBAIKAN DI SINI 🔥
            // Gunakan integer biasa karena tabel users Mas pakai int(11) biasa
            $table->integer('user_id'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Biodata
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->text('alamat_asal'); 
            $table->string('agama');
            $table->string('status_perkawinan');
            $table->string('pekerjaan');

            $table->text('keperluan'); 
            $table->string('foto_surat'); 
            
            $table->string('status')->default('menunggu'); 
            $table->text('pesan_admin')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapor_diris');
    }
};