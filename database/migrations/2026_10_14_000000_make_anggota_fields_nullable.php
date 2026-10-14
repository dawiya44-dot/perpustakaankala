<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat kolom tgllahir, tempatlahir, dan kelas pada tabel anggota menjadi nullable
     * agar bisa diisi otomatis saat user register tanpa data lengkap.
     */
    public function up(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->date('tgllahir')->nullable()->change();
            $table->string('tempatlahir', 30)->nullable()->change();
            $table->string('kelas', 10)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('anggota', function (Blueprint $table) {
            $table->date('tgllahir')->nullable(false)->change();
            $table->string('tempatlahir', 30)->nullable(false)->change();
            $table->string('kelas', 10)->nullable(false)->change();
        });
    }
};
