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
        Schema::table('berita', function (Blueprint $table) {
            // Menambahkan kolom 'slug' setelah kolom 'judul'
            $table->string('slug')->unique()->after('judul');
            // Menambahkan kolom 'gambar' setelah kolom 'isi', boleh kosong (nullable)
            $table->string('gambar')->nullable()->after('isi');
        });
    }

    public function down(): void
    {
        Schema::table('berita', function (Blueprint $table) {
            // Perintah untuk menghapus kolom jika migrasi dibatalkan
            $table->dropColumn(['slug', 'gambar']);
        });
    }
};
