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
        Schema::create('surat_pengantar_skck', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('surat_id')->nullable()->index('surat_id');
            $table->integer('biodata_id')->nullable()->index('biodata_id');
            $table->text('keperluan')->nullable();
            $table->string('nomor_surat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_pengantar_skck');
    }
};
