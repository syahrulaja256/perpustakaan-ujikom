<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PeminjamanController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrasiController;
use App\Http\Controllers\Petugas\PetugasController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $totalBuku = \App\Models\Buku::count();
    $totalUser = \App\Models\User::where('role', 'user')->count();
    $totalPeminjaman = \App\Models\Peminjaman::count();
    $avgRating = \App\Models\Peminjaman::whereNotNull('rating')->where('rating', '>', 0)->avg('rating');

    return view('welcome', [
        'totalBuku' => $totalBuku,
        'totalUser' => $totalUser,
        'totalPeminjaman' => $totalPeminjaman,
        'avgRating' => round($avgRating ?? 0, 1),
    ]);
});


/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/registrasi', [RegistrasiController::class, 'index'])->name('registrasi');
Route::post('/registrasi', [RegistrasiController::class, 'store']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

// PROFILE (semua role)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


/*
|--------------------------------------------------------------------------
| USER
|--------------------------------------------------------------------------
*/

Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', 'role:user'])
    ->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

        Route::post('/favorite/add', [UserController::class, 'addFavorite'])->name('favorite.add');
        Route::get('/favorites', [UserController::class, 'favorites'])->name('favorites');
        Route::post('/favorite/remove/{id}', [UserController::class, 'removeFavorite'])->name('favorite.remove');

        // PEMINJAMAN
        Route::get('/peminjaman/{buku_id}', [UserController::class, 'peminjamanForm'])->name('peminjaman.form');
        Route::post('/peminjaman/submit', [UserController::class, 'peminjamanSubmit'])->name('peminjaman.submit');

        // RIWAYAT
        Route::get('/riwayat', [UserController::class, 'riwayat'])->name('riwayat');
        // FORM ULASAN
        Route::get('/kembalikan/{id}', [UserController::class, 'kembalikanForm'])->name('kembalikan.form');

        // KEMBALIKAN BUKU
        Route::post('/kembalikan/{id}', [UserController::class, 'kembalikanBuku'])->name('kembalikan.buku');

        // CETAK PDF PEMINJAMAN
        Route::get('/cetak/peminjaman/{id}', [UserController::class, 'cetakPeminjaman'])->name('cetak.peminjaman');

        // CETAK PDF PENGEMBALIAN
        Route::get('/cetak/pengembalian/{id}', [UserController::class, 'cetakPengembalian'])->name('cetak.pengembalian');

        // SUBMIT ULASAN
        Route::post('/ulasan/submit', [UserController::class, 'submitUlasan'])->name('ulasan.submit');

        // LIST ULASAN
        Route::get('/ulasan', [UserController::class, 'ulasanList'])->name('ulasan.list');
    });


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/kelola-buku', [BukuController::class, 'index'])->name('kelola_buku');

        Route::post('/bukus', [BukuController::class, 'store'])->name('bukus.store');

        Route::get('/bukus/edit/{id}', [BukuController::class, 'edit'])->name('bukus.edit');

        Route::post('/bukus/update/{id}', [BukuController::class, 'update'])->name('bukus.update');

        Route::delete('/bukus/{id}', [BukuController::class, 'destroy'])->name('bukus.destroy');

        Route::get('/kategori', [AdminController::class, 'kelolaKategori'])->name('kategori');

        Route::post('/kategori/store', [AdminController::class, 'storeKategori'])->name('kategori.store');

        Route::get('/petugas', [AdminController::class, 'kelolaPetugas'])->name('petugas');
        Route::post('/petugas/store', [AdminController::class, 'storePetugas'])->name('petugas.store');
        Route::delete('/petugas/{id}', [AdminController::class, 'hapusPetugas'])->name('petugas.hapus');

        Route::get('/user', [AdminController::class, 'kelolaUser'])->name('user');

        // ROUTE HAPUS USER
        Route::delete('/user/{id}', [App\Http\Controllers\Admin\UserController::class, 'hapus'])
            ->name('user.hapus');

        // HALAMAN PEMINJAMAN
        Route::get('/peminjaman', [AdminController::class, 'peminjaman'])->name('peminjaman');

        // KONFIRMASI PEMINJAMAN
        Route::get('/peminjaman/konfirmasi/{id}', [PeminjamanController::class, 'konfirmasi'])
            ->name('peminjaman.konfirmasi');

        Route::get('/riwayat', [AdminController::class, 'riwayat'])->name('riwayat');

        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');

        // KONFIRMASI PENGEMBALIAN
        Route::post('/peminjaman/konfirmasi-pengembalian/{id}', [AdminController::class, 'konfirmasiPengembalian'])
            ->name('peminjaman.konfirmasi_pengembalian');

        // CETAK LAPORAN PDF
        Route::get('/cetak/laporan', [AdminController::class, 'cetakLaporan'])->name('cetak.laporan');

        // LAPORAN BUKU
        Route::get('/laporan-buku', [AdminController::class, 'laporanBuku'])->name('laporan.buku');
        Route::get('/cetak/laporan-buku', [AdminController::class, 'cetakLaporanBuku'])->name('cetak.laporan.buku');

        // LAPORAN USER
        Route::get('/laporan-user', [AdminController::class, 'laporanUser'])->name('laporan.user');
        Route::get('/cetak/laporan-user', [AdminController::class, 'cetakLaporanUser'])->name('cetak.laporan.user');

        // CETAK PENGEMBALIAN
        Route::get('/cetak/pengembalian/{id}', [AdminController::class, 'cetakPengembalian'])->name('cetak.pengembalian');

        // CETAK PEMINJAMAN
        Route::get('/cetak/peminjaman/{id}', [AdminController::class, 'cetakPeminjaman'])->name('cetak.peminjaman');
    });


/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/

Route::prefix('petugas')
    ->name('petugas.')
    ->middleware(['auth', 'role:petugas'])
    ->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');

        Route::get('/buku', [PetugasController::class, 'buku'])->name('buku');
        Route::post('/buku/store', [PetugasController::class, 'storeBuku'])->name('buku.store');

        Route::get('/kategori', [PetugasController::class, 'kategori'])->name('kategori');
        Route::post('/kategori/store', [PetugasController::class, 'storeKategori'])->name('kategori.store');

        Route::get('/peminjaman', [PetugasController::class, 'peminjaman'])->name('peminjaman');

        Route::post('/peminjaman/konfirmasi/{id}', [PetugasController::class, 'konfirmasi'])->name('konfirmasi');

        Route::post('/peminjaman/tolak/{id}', [PetugasController::class, 'tolak'])->name('tolak');

        Route::get('/laporan', [PetugasController::class, 'laporan'])->name('laporan');

        // KONFIRMASI PENGEMBALIAN
        Route::post('/peminjaman/konfirmasi-pengembalian/{id}', [PetugasController::class, 'konfirmasiPengembalian'])
            ->name('konfirmasi_pengembalian');

        // CETAK LAPORAN PDF
        Route::get('/cetak/laporan', [PetugasController::class, 'cetakLaporan'])->name('cetak.laporan');

        // LAPORAN BUKU
        Route::get('/laporan-buku', [PetugasController::class, 'laporanBuku'])->name('laporan.buku');
        Route::get('/cetak/laporan-buku', [PetugasController::class, 'cetakLaporanBuku'])->name('cetak.laporan.buku');

        // CETAK PENGEMBALIAN
        Route::get('/cetak/pengembalian/{id}', [PetugasController::class, 'cetakPengembalian'])->name('cetak.pengembalian');

        // CETAK PEMINJAMAN
        Route::get('/cetak/peminjaman/{id}', [PetugasController::class, 'cetakPeminjaman'])->name('cetak.peminjaman');
    });
