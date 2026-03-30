<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Buku</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; color: #333; padding: 30px; }
        .header { text-align: center; border-bottom: 3px solid #4f46e5; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 20px; color: #4f46e5; }
        .header p { font-size: 11px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #4f46e5; color: white; padding: 8px; text-align: left; font-size: 11px; }
        td { padding: 7px 8px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        .footer { margin-top: 25px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📚 PERPUSTAKAAN DIGITAL</h1>
        <p>Laporan Data Buku</p>
        <p style="margin-top:3px; font-size:10px;">Dicetak: {{ date('d F Y, H:i') }}</p>
    </div>
    <p style="margin-bottom:10px; font-size:11px;">Total: <strong>{{ count($bukus) }}</strong> buku</p>
    <table>
        <thead>
            <tr>
                <th>No</th><th>Judul</th><th>Penulis</th><th>Penerbit</th><th>Tahun</th><th>Kategori</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bukus as $i => $b)
            <tr>
                <td>{{ $i+1 }}</td><td>{{ $b->judul }}</td><td>{{ $b->penulis }}</td><td>{{ $b->penerbit }}</td><td>{{ $b->tahun_terbit }}</td><td>{{ $b->kategori->nama ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">Perpustakaan Digital &bull; Laporan dihasilkan secara otomatis</div>
</body>
</html>
