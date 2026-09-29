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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('id_pinjam', 15)->primary();
            $table->dateTime('tgl_pinjam');
            $table->dateTime('tgl_kembali')->nullable();
            $table->dateTime('tgl_dikembalikan')->nullable();
            $table->integer('denda')->default(0);
            $table->string('id_anggota', 10);
            $table->string('no_buku', 20);
            $table->string('status', 20);
            $table->timestamps();
            
            $table->foreign('id_anggota')->references('id_anggota')->on('anggota')->onDelete('cascade');
            $table->foreign('no_buku')->references('no_buku')->on('detail_buku')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
