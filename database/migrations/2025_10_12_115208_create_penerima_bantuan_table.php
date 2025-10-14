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
        Schema::create('penerima_bantuan', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('program_id')->nullable()->index('program_id');
            $table->integer('biodata_id')->nullable()->index('biodata_id');
            $table->string('jenis_bantuan')->nullable();
            $table->decimal('jumlah_bantuan', 15)->nullable()->default(0);
            $table->dateTime('tanggal_pemberian')->nullable();
            $table->text('keterangan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerima_bantuan');
    }
};
