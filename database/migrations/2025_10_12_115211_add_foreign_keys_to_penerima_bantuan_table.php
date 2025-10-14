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
        Schema::table('penerima_bantuan', function (Blueprint $table) {
            $table->foreign(['program_id'], 'penerima_bantuan_ibfk_1')->references(['id'])->on('program_bantuan')->onUpdate('restrict')->onDelete('restrict');
            $table->foreign(['biodata_id'], 'penerima_bantuan_ibfk_2')->references(['id'])->on('biodata')->onUpdate('restrict')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penerima_bantuan', function (Blueprint $table) {
            $table->dropForeign('penerima_bantuan_ibfk_1');
            $table->dropForeign('penerima_bantuan_ibfk_2');
        });
    }
};
