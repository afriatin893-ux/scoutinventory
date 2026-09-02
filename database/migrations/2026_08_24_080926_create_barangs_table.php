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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id('id_barang');
            $table->foreignId('id_kategori')->constrained('categories', 'id_kategori');
            $table->string('kode_barang', 50);
            $table->string('nama_barang', 100);
            $table->string('foto')->nullable();
            $table->integer('stok');
            $table->string('kondisi', 50);
            $table->string('lokasi', 100);
            $table->date('tanggal_pengadaan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
