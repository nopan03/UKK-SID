<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Mengubah nama kolom 'username' menjadi 'name'
            $table->renameColumn('username', 'name');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Perintah untuk mengembalikan jika diperlukan
            $table->renameColumn('name', 'username');
        });
    }
};