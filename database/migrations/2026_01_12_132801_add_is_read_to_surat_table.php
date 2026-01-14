<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Perhatikan: nama tabelnya 'surat' (sesuai screenshot Anda)
        Schema::table('surat', function (Blueprint $table) {
            // Kolom penanda: 0 = Belum Dilihat (Merah), 1 = Sudah Dilihat (Hilang)
            $table->boolean('is_read')->default(false)->after('status');
        });
    }

    public function down()
    {
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
    }
};