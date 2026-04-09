<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'user_id',
        'buku_id',
        'kelas',
        'jurusan',
        'no_hp',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'rating',
        'ulasan',
        'dikonfirmasi_oleh',
        'jumlah',
        'batas_hari',
        'alasan_terlambat',
        'terlambat',
        'tanggal_pengembalian_aktual'
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
