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
        Schema::create('keuangan_desa', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('jenis')->nullable();
            $table->string('kategori')->nullable();
            $table->decimal('jumlah', 15)->nullable()->default(0);
            $table->text('keterangan')->nullable();
            $table->date('tanggal')->nullable();
            $table->integer('dibuat_oleh')->nullable()->index('dibuat_oleh');
            $table->dateTime('created_at')->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuangan_desa');
    }
};
