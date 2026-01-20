<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_pengantar_skck', function (Blueprint $table) {
            $table->id(); // Pengganti integer('id', true)

            // 🔥 PERBAIKAN: Ganti integer jadi unsignedBigInteger
            $table->unsignedBigInteger('surat_id')->nullable()->index('surat_id');
            $table->unsignedBigInteger('biodata_id')->nullable()->index('biodata_id');
            
            $table->text('keperluan')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->timestamps();
            $table->string('file_ktp')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_akta')->nullable();
            $table->string('file_pengantar')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengantar_skck');
    }
};