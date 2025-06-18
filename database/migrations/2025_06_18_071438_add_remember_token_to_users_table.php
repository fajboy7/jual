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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom 'remember_token' sebagai string nullable (tipe data yang tepat untuk token ini)
            $table->rememberToken(); // Ini adalah shorthand Laravel untuk string(100)->nullable()
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom 'remember_token' jika migrasi di-rollback
            $table->dropColumn('remember_token');
        });
    }
};