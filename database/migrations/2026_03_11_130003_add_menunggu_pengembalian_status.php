<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Alter enum to include 'Menunggu Pengembalian'
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('Menunggu', 'Dikonfirmasi', 'Ditolak', 'Dikembalikan', 'Menunggu Pengembalian') DEFAULT 'Menunggu'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('Menunggu', 'Dikonfirmasi', 'Ditolak', 'Dikembalikan') DEFAULT 'Menunggu'");
    }
};
