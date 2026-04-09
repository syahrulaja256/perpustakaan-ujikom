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
        Schema::table('peminjamans', function (Blueprint $table) {
            // Tambah field untuk batas waktu pengembalian (dalam hari)
            $table->integer('batas_hari')->default(7)->after('tanggal_kembali');

            // Tambah field untuk alasan pengembalian terlambat
            $table->text('alasan_terlambat')->nullable()->after('ulasan');

            // Tambah field untuk status pengembalian terlambat
            $table->boolean('terlambat')->default(false)->after('alasan_terlambat');

            // Tambah field untuk tanggal pengembalian aktual
            $table->date('tanggal_pengembalian_aktual')->nullable()->after('terlambat');
        });

        // Update enum status untuk menambahkan status baru
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('Menunggu', 'Dikonfirmasi', 'Ditolak', 'Dikembalikan', 'Menunggu Pengembalian', 'Pengembalian Terlambat', 'Ditolak Terlambat') DEFAULT 'Menunggu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['batas_hari', 'alasan_terlambat', 'terlambat', 'tanggal_pengembalian_aktual']);
        });

        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('Menunggu', 'Dikonfirmasi', 'Ditolak', 'Dikembalikan', 'Menunggu Pengembalian') DEFAULT 'Menunggu'");
    }
};