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
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('buku_id');

            $table->string('kelas');
            $table->string('jurusan');
            $table->string('no_hp');

            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');

            $table->enum('status', [
                'Menunggu',
                'Dikonfirmasi',
                'Ditolak',
                'Dikembalikan'
            ])->default('Menunggu');

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('buku_id')->references('id')->on('bukus')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};
