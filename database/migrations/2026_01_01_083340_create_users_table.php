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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name')->unique('username');
            $table->string('email')->nullable()->unique('email');
            $table->string('password');
            
            // 🔥 PERUBAHAN DI SINI 🔥
            // Dulu: Enum (Kaku) -> Sekarang: String (Fleksibel)
            // Bisa menampung: 'admin', 'warga', 'pengunjung', 'pendatang', dll.
            $table->string('role', 50)->nullable()->default('warga');
            
            $table->string('nik')->nullable()->unique('nik');
            $table->dateTime('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->useCurrentOnUpdate()->nullable()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};