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
        Schema::create('pengembalians', function (Blueprint $table) {
             $table->id('id_pengembalian');
             $table->foreignId('id_peminjaman')->constrained('peminjamans', 'id_peminjaman');
             $table->date('tanggal_pengembalian');
             $table->integer('jumlah_kembali');
             $table->string('kondisi_barang', 50);
             $table->string('foto_kondisi', 255)->nullable();
             $table->text('catatan')->nullable();
             $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};
