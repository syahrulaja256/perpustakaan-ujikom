<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule untuk mengecek pengembalian terlambat setiap hari pukul 00:01
Schedule::command('app:check-late-returns')
    ->dailyAt('00:01')
    ->description('Check for late book returns and update status automatically');
