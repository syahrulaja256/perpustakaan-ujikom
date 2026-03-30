<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Struk Pengembalian - Petugas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 13px; color: #333; padding: 40px; }
        .header { text-align: center; border-bottom: 3px solid #0891b2; padding-bottom: 20px; margin-bottom: 25px; }
        .header h1 { font-size: 22px; color: #0891b2; }
        .header p { font-size: 11px; color: #666; }
        .badge { display: inline-block; background: #059669; color: white; padding: 4px 12px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .checkmark { text-align: center; margin: 15px 0 20px; }
        .checkmark-circle { display: inline-block; width: 50px; height: 50px; background: #d1fae5; border-radius: 50%; line-height: 50px; font-size: 24px; color: #059669; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .info-table td { padding: 8px 12px; border: 1px solid #e5e7eb; }
        .info-table td:first-child { background: #ecfeff; font-weight: bold; width: 35%; color: #0e7490; }
        .footer { margin-top: 35px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 PERPUSTAKAAN DIGITAL</h1>
        <p>Struk Pengembalian Buku (Petugas)</p>
    </div>
    <div class="checkmark">
        <div class="checkmark-circle">✓</div>
        <p><span class="badge">BUKU TELAH DIKEMBALIKAN</span></p>
    </div>
    <p style="margin-bottom:10px;"><span style="background:#e0e7ff;color:#4f46e5;padding:3px 10px;border-radius:4px;font-size:11px;font-weight:bold;">ID: #{{ str_pad($peminjaman->id, 5, '0', STR_PAD_LEFT) }}</span></p>
    <table class="info-table">
        <tr><td>Nama Peminjam</td><td>{{ $peminjaman->user->name ?? '-' }}</td></tr>
        <tr><td>Judul Buku</td><td>{{ $peminjaman->buku->judul ?? '-' }}</td></tr>
        <tr><td>Penulis</td><td>{{ $peminjaman->buku->penulis ?? '-' }}</td></tr>
        <tr><td>Tanggal Pinjam</td><td>{{ $peminjaman->tanggal_pinjam }}</td></tr>
        <tr><td>Tanggal Kembali</td><td>{{ $peminjaman->tanggal_kembali }}</td></tr>
        <tr><td>Status</td><td style="color:#059669;font-weight:bold;">Dikembalikan</td></tr>
    </table>
    <table style="width:100%;margin-top:35px;">
        <tr>
            <td style="width:50%;text-align:center;">
                <p style="font-size:11px;color:#666;">Petugas Perpustakaan</p><br><br><br>
                <p style="border-top:1px solid #333;display:inline-block;padding-top:5px;width:150px;">( __________________ )</p>
            </td>
            <td style="width:50%;text-align:center;">
                <p style="font-size:11px;color:#666;">Peminjam</p><br><br><br>
                <p style="border-top:1px solid #333;display:inline-block;padding-top:5px;width:150px;">( {{ $peminjaman->user->name ?? '' }} )</p>
            </td>
        </tr>
    </table>
    <div class="footer">Dicetak pada {{ date('d/m/Y H:i') }} &bull; Perpustakaan Digital</div>
</body>
</html>
