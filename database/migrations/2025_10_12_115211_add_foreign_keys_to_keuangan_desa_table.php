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
        Schema::table('keuangan_desa', function (Blueprint $table) {
            $table->foreign(['dibuat_oleh'], 'keuangan_desa_ibfk_1')->references(['id'])->on('users')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keuangan_desa', function (Blueprint $table) {
            $table->dropForeign('keuangan_desa_ibfk_1');
        });
    }
};
