# Dokumentasi Fitur Ulasan - Alur Lengkap

## 📋 Ringkasan
Fitur ini memungkinkan admin untuk melihat, mengelola, dan menghapus ulasan (reviews) yang diberikan oleh pengguna perpustakaan.

---

## 🔄 Alur Proses

### 1. **User Memberikan Ulasan**
- User mengakses halaman "Riwayat Peminjaman" (`/user/riwayat`)
- User klik tombol "Kembalikan" pada buku yang sudah selesai
- User diajak ke form pengembalian (`/user/kembalikan/{id}`)
- User mengisi form dengan:
  - Rating (bintang 1-5)
  - Ulasan (text)
- User klik submit
- Data disimpan ke table `peminjamans` dengan field `rating` dan `ulasan` terisi

### 2. **Admin Melihat Ulasan**
- Admin login ke dashboard admin
- Admin melihat card "Total Ulasan" yang menampilkan jumlah ulasan masuk
- Admin klik card ulasan atau menu "Ulasan" di sidebar
- Admin diarahkan ke halaman `/admin/ulasan`

### 3. **Halaman List Ulasan Admin**
- Admin melihat tabel daftar semua ulasan
- Informasi yang ditampilkan:
  - Nama pengguna
  - Judul buku
  - Rating (bintang)
  - Preview ulasan
  - Tanggal ulasan
  - Aksi (Lihat, Hapus)
- Admin bisa melihat pagination
- Admin bisa klik "Lihat" untuk melihat detail lengkap

### 4. **Detail Ulasan**
- Admin klik "Lihat" pada salah satu ulasan
- Halaman detail menampilkan:
  - Informasi pengguna (nama, email)
  - Informasi buku (judul, penulis, penerbit)
  - Rating dalam bentuk bintang dan angka
  - Ulasan lengkap
  - Tanggal peminjaman dan pengembalian
  - Status peminjaman
  - Tombol "Hapus" untuk menghapus ulasan

### 5. **Menghapus Ulasan**
- Admin bisa menghapus ulasan dari halaman list atau detail
- Sistem akan menghapus isi field `ulasan` dan `rating`
- Admin dikembalikan ke halaman list dengan pesan sukses

---

## 📁 File-File yang Dibuat

### Backend
```
app/Http/Controllers/Admin/UlasanController.php
├── index()     - Menampilkan list ulasan
├── show($id)   - Menampilkan detail ulasan
└── destroy($id)- Menghapus ulasan
```

### Frontend (Views)
```
resources/views/admin/ulasan/
├── index.blade.php  - Halaman list ulasan
└── show.blade.php   - Halaman detail ulasan
```

### Routing
```
routes/web.php
├── GET  /admin/ulasan           -> admin.ulasan.index
├── GET  /admin/ulasan/{id}      -> admin.ulasan.show
└── DELETE /admin/ulasan/{id}    -> admin.ulasan.destroy
```

### Navigation
```
resources/views/components/admin/sidebar.blade.php
- Menu "Ulasan" dengan icon bintang (fa-solid fa-star)
```

---

## 🗄️ Database

### Table: `peminjamans`
Kolom yang relevan:
- `id` - ID peminjaman
- `user_id` - Foreign key ke users
- `buku_id` - Foreign key ke bukus
- `rating` - Nilai rating (1-5)
- `ulasan` - Text ulasan
- `status` - Status peminjaman
- `tanggal_pinjam` - Tanggal peminjaman
- `tanggal_kembali` - Tanggal pengembalian
- `updated_at` - Waktu ulasan dibuat/diupdate

---

## 🔗 Model Relationships

```php
// Peminjaman.php
belongsTo(User::class)
belongsTo(Buku::class)

// User.php (NEW)
hasMany(Peminjaman::class)

// Buku.php
hasMany(Peminjaman::class)
```

---

## 📊 Dashboard Update

Admin dashboard menampilkan card baru:
- **Total Ulasan** - Menghitung peminjaman dengan ulasan tidak null
- Klik card untuk langsung ke halaman list ulasan

---

## 🎨 UI Features

### List Ulasan
- ✅ Tabel responsif dengan pagination
- ✅ Colored badges untuk rating
- ✅ Bintang visual untuk rating
- ✅ Aksi buttons (Lihat, Hapus)
- ✅ Konfirmasi sebelum hapus
- ✅ Alert sukses/error
- ✅ Empty state jika belum ada ulasan

### Detail Ulasan
- ✅ Avatar user dengan inisial
- ✅ Informasi buku dalam card terpisah
- ✅ Rating tampil dengan visual bintang
- ✅ Ulasan dengan whitespace preserved
- ✅ Timeline informasi (tgl peminjaman, tgl kembali, status)
- ✅ Tombol kembali dan hapus

### Sidebar Menu
- ✅ Active state indicator
- ✅ Icon bintang untuk visual ulasan
- ✅ Hover effects

---

## 🚀 Testing Checklist

- [ ] Cek routes sudah terdaftar dengan `php artisan route:list`
- [ ] Cek syntax controller dengan `php -l`
- [ ] Login sebagai admin
- [ ] Lihat menu "Ulasan" di sidebar
- [ ] Klik menu untuk ke halaman list ulasan
- [ ] Verifikasi halaman menampilkan ulasan yang ada
- [ ] Klik "Lihat" untuk lihat detail
- [ ] Lihat dashboard card "Total Ulasan"
- [ ] Klik "Hapus" dan verifikasi konfirmasi
- [ ] Setelah hapus, verifikasi ulasan hilang dari list

---

## 📝 Query Used

Admin melihat ulasan:
```php
Peminjaman::whereNotNull('ulasan')
    ->where('ulasan', '!=', '')
    ->with(['user', 'buku'])
    ->orderBy('updated_at', 'desc')
    ->paginate(10)
```

Dashboard ulasan count:
```php
Peminjaman::whereNotNull('ulasan')
    ->where('ulasan', '!=', '')
    ->count()
```

---

## 🔒 Security

- ✅ Routes protected dengan middleware `['auth', 'role:admin']`
- ✅ Hanya admin yang bisa akses halaman ulasan
- ✅ User tidak bisa hapus ulasan user lain (karena halaman cuma bisa diakses admin)

