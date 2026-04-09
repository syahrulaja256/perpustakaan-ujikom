@extends('layouts.user')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fa-solid fa-clock text-red-600 text-xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pengembalian Terlambat</h1>
                    <p class="text-gray-600">Pengembalian Anda terlambat {{ $hariTerlambat }} hari</p>
                </div>
            </div>

            <!-- Info Buku -->
            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                <h3 class="font-semibold text-gray-900 mb-2">{{ $peminjaman->buku->judul }}</h3>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">Tanggal Pinjam:</span>
                        <br>{{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}
                    </div>
                    <div>
                        <span class="font-medium">Batas Kembali:</span>
                        <br>{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start gap-3">
                    <i class="fa-solid fa-exclamation-triangle text-red-600 mt-1"></i>
                    <div>
                        <h4 class="font-semibold text-red-900 mb-1">Pengembalian Terlambat</h4>
                        <p class="text-red-700 text-sm">
                            Buku ini seharusnya dikembalikan pada tanggal {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}
                            namun Anda mengembalikannya {{ $hariTerlambat }} hari terlambat.
                        </p>
                        <p class="text-red-700 text-sm mt-2">
                            <strong>Silakan berikan alasan pengembalian terlambat untuk mendapatkan konfirmasi dari admin/petugas.</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Alasan -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <form action="{{ route('user.alasan_terlambat.submit', $peminjaman->id) }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label for="alasan_terlambat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Pengembalian Terlambat <span class="text-red-500">*</span>
                    </label>
                    <textarea
                        id="alasan_terlambat"
                        name="alasan_terlambat"
                        rows="6"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                        placeholder="Jelaskan alasan mengapa buku dikembalikan terlambat... (minimal 10 karakter)"
                        required
                    ></textarea>
                    <p class="text-xs text-gray-500 mt-1">Minimal 10 karakter, maksimal 500 karakter</p>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors font-medium">
                        <i class="fa-solid fa-paper-plane mr-2"></i>
                        Kirim Alasan
                    </button>
                    <a href="{{ route('user.riwayat') }}" class="px-6 py-3 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors font-medium">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <!-- Info Tambahan -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-6">
            <div class="flex items-start gap-3">
                <i class="fa-solid fa-info-circle text-blue-600 mt-1"></i>
                <div>
                    <h4 class="font-semibold text-blue-900 mb-1">Informasi</h4>
                    <ul class="text-blue-800 text-sm space-y-1">
                        <li>• Setelah mengirim alasan, admin/petugas akan meninjau pengembalian Anda</li>
                        <li>• Anda akan menerima notifikasi setelah pengembalian dikonfirmasi</li>
                        <li>• Pastikan alasan yang diberikan jelas dan dapat dipertanggungjawabkan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection