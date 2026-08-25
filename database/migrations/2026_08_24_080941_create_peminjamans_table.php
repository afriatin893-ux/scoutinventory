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
        Schema::create('peminjamans', function (Blueprint $table) {
           $table->id('id_peminjaman');
           $table->foreignId('id_peminjam')->constrained('peminjams', 'id_peminjam');
           $table->foreignId('id_admin')->nullable()->constrained('admins', 'id_admin');
           $table->date('tanggal_pinjam');
           $table->date('tanggal_rencana_kembali');
           $table->text('keperluan');
           $table->string('status', 20);
           $table->text('catatan_admin')->nullable();
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
