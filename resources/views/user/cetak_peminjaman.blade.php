<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Bukti Peminjaman Buku</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 13px; color: #333; padding: 40px; }
        .header { text-align: center; border-bottom: 3px solid #0d9488; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { font-size: 22px; color: #0d9488; margin-bottom: 5px; }
        .header p { font-size: 11px; color: #666; }
        .badge { display: inline-block; background: #0d9488; color: white; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .info-table td { padding: 8px 12px; border: 1px solid #e5e7eb; }
        .info-table td:first-child { background: #f8fafc; font-weight: bold; width: 35%; color: #475569; }
        .footer { margin-top: 40px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e5e7eb; padding-top: 15px; }
        .signature { margin-top: 40px; display: flex; }
        .sig-box { width: 50%; text-align: center; }
        .sig-line { margin-top: 60px; border-top: 1px solid #333; display: inline-block; width: 150px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>📚 PERPUSTAKAAN DIGITAL</h1>
        <p>Bukti Peminjaman Buku</p>
    </div>

    <p style="margin-bottom: 10px;">
        <span class="badge">ID: #{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}</span>
    </p>

    <table class="info-table">
        <tr>
            <td>Nama Peminjam</td>
            <td>{{ $peminjaman->user->name ?? '-' }}</td>
        </tr>
        <tr>
            <td>Judul Buku</td>
            <td>{{ $peminjaman->buku->judul ?? '-' }}</td>
        </tr>
        <tr>
            <td>Penulis</td>
            <td>{{ $peminjaman->buku->penulis ?? '-' }}</td>
        </tr>
        <tr>
            <td>Kelas</td>
            <td>{{ $peminjaman->kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td>Jurusan</td>
            <td>{{ $peminjaman->jurusan ?? '-' }}</td>
        </tr>
        <tr>
            <td>No HP</td>
            <td>{{ $peminjaman->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <td>Tanggal Pinjam</td>
            <td>{{ $peminjaman->tanggal_pinjam }}</td>
        </tr>
        <tr>
            <td>Tanggal Kembali</td>
            <td>{{ $peminjaman->tanggal_kembali }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $peminjaman->status }}</td>
        </tr>
    </table>

    <table style="width:100%; margin-top:40px;">
        <tr>
            <td style="width:50%; text-align:center;">
                <p style="font-size:11px; color:#666;">Petugas Perpustakaan</p>
                <br><br><br>
                <p style="border-top:1px solid #333; display:inline-block; padding-top:5px; width:150px;">( __________________ )</p>
            </td>
            <td style="width:50%; text-align:center;">
                <p style="font-size:11px; color:#666;">Peminjam</p>
                <br><br><br>
                <p style="border-top:1px solid #333; display:inline-block; padding-top:5px; width:150px;">( {{ $peminjaman->user->name ?? '' }} )</p>
            </td>
        </tr>
    </table>

    <div class="footer">
        Dicetak pada {{ date('d/m/Y H:i') }} &bull; Perpustakaan Digital
    </div>

</body>
</html>
