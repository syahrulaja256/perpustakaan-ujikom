<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 12px; color: #333; padding: 30px; }
        .header { text-align: center; border-bottom: 3px solid #4f46e5; padding-bottom: 15px; margin-bottom: 25px; }
        .header h1 { font-size: 20px; color: #4f46e5; margin-bottom: 3px; }
        .header p { font-size: 11px; color: #666; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th { background: #4f46e5; color: white; padding: 8px 10px; text-align: left; font-size: 11px; font-weight: bold; }
        td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        tr:nth-child(even) { background: #f8fafc; }
        .status { display: inline-block; padding: 2px 8px; border-radius: 3px; font-size: 10px; font-weight: bold; }
        .status-pinjam { background: #dbeafe; color: #2563eb; }
        .status-kembali { background: #d1fae5; color: #059669; }
        .status-tunggu { background: #fef3c7; color: #d97706; }
        .status-tolak { background: #fee2e2; color: #dc2626; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        .summary { margin-top: 15px; font-size: 11px; color: #666; }
    </style>
</head>
<body>

    <div class="header">
        <h1>📚 PERPUSTAKAAN DIGITAL</h1>
        <p>Laporan Data Peminjaman Buku</p>
        <p style="margin-top:5px; font-size:10px;">Dicetak: {{ date('d F Y, H:i') }}</p>
    </div>

    <p class="summary">Total data: <strong>{{ count($laporan) }}</strong> peminjaman</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Judul Buku</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r->user->name ?? '-' }}</td>
                    <td>{{ $r->buku->judul ?? '-' }}</td>
                    <td>{{ $r->tanggal_pinjam }}</td>
                    <td>{{ $r->tanggal_kembali }}</td>
                    <td>
                        @if($r->status == 'Dikonfirmasi')
                            <span class="status status-pinjam">Dipinjam</span>
                        @elseif($r->status == 'Dikembalikan')
                            <span class="status status-kembali">Dikembalikan</span>
                        @elseif($r->status == 'Menunggu')
                            <span class="status status-tunggu">Menunggu</span>
                        @elseif($r->status == 'Ditolak')
                            <span class="status status-tolak">Ditolak</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:20px;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <table style="width:100%; margin-top:40px; border:none;">
        <tr>
            <td style="width:60%; border:none;"></td>
            <td style="width:40%; text-align:center; border:none;">
                <p style="font-size:11px; color:#666;">Mengetahui,</p>
                <p style="font-size:11px; color:#666;">Admin Perpustakaan</p>
                <br><br><br>
                <p style="border-top:1px solid #333; display:inline-block; padding-top:5px; width:150px;">( __________________ )</p>
            </td>
        </tr>
    </table>

    <div class="footer">
        Perpustakaan Digital &bull; Laporan dihasilkan secara otomatis
    </div>

</body>
</html>
