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
        Schema::table('surat_pengantar_skck', function (Blueprint $table) {
            $table->foreign(['surat_id'], 'surat_pengantar_skck_ibfk_1')->references(['id'])->on('surat')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['biodata_id'], 'surat_pengantar_skck_ibfk_2')->references(['id'])->on('biodata')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('surat_pengantar_skck', function (Blueprint $table) {
            $table->dropForeign('surat_pengantar_skck_ibfk_1');
            $table->dropForeign('surat_pengantar_skck_ibfk_2');
        });
    }
};
