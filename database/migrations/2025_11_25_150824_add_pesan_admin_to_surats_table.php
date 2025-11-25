<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Ganti 'surats' menjadi 'surat' (sesuai nama tabel di database Anda)
        Schema::table('surat', function (Blueprint $table) {
            // Menambah kolom pesan_admin setelah kolom status
            $table->text('pesan_admin')->nullable()->after('status');
        });
    }

    public function down()
    {
        // Ganti 'surats' menjadi 'surat'
        Schema::table('surat', function (Blueprint $table) {
            $table->dropColumn('pesan_admin');
        });
    }
};