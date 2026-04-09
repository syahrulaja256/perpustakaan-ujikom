<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Peminjaman;
use Carbon\Carbon;

class CheckLateReturns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-late-returns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for late book returns and update status automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for late returns...');

        // Cari peminjaman yang sudah melewati batas waktu pengembalian
        $lateReturns = Peminjaman::where('status', 'Dikonfirmasi')
            ->where('tanggal_kembali', '<', Carbon::now()->toDateString())
            ->get();

        $count = 0;
        foreach ($lateReturns as $peminjaman) {
            // Hitung berapa hari terlambat
            $tanggalKembali = Carbon::parse($peminjaman->tanggal_kembali);
            $hariTerlambat = Carbon::now()->diffInDays($tanggalKembali);

            // Update status menjadi terlambat
            $peminjaman->update([
                'status' => 'Pengembalian Terlambat',
                'terlambat' => true,
                'tanggal_pengembalian_aktual' => Carbon::now()->toDateString()
            ]);

            $this->info("Updated peminjaman ID {$peminjaman->id} - {$hariTerlambat} hari terlambat");
            $count++;
        }

        $this->info("Checked {$lateReturns->count()} peminjaman, updated {$count} late returns.");
    }
}
