@extends('layouts.admin')

@section('page-title', 'Laporan Peminjaman')
@section('page-subtitle', 'Rekap data peminjaman perpustakaan')

@section('content')
    <div class="space-y-5 animate-fade-in-up">

        {{-- Action --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">
                Total <span class="font-semibold text-slate-700">{{ count($laporan) }}</span> data peminjaman
            </p>
            <a href="{{ route('admin.cetak.laporan') }}" target="_blank"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-violet-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-indigo-500/30 transition-all duration-300">
                <i class="fa-solid fa-file-pdf"></i>
                Cetak Laporan PDF
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-indigo-600 to-violet-600 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Nama User</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Judul Buku</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Tgl Pinjam</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Tgl Kembali</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($laporan as $i => $r)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700">{{ $r->user->name ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-600">{{ $r->buku->judul ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $r->tanggal_pinjam }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $r->tanggal_kembali }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    @if ($r->status == 'Menunggu')
                                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-600 px-3 py-1 rounded-lg text-xs font-semibold">Menunggu</span>
                                    @elseif($r->status == 'Dikonfirmasi')
                                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-xs font-semibold">Dipinjam</span>
                                    @elseif($r->status == 'Dikembalikan')
                                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg text-xs font-semibold">Dikembalikan</span>
                                    @elseif($r->status == 'Ditolak')
                                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-3 py-1 rounded-lg text-xs font-semibold">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12">
                                    <p class="text-slate-400 text-sm">Belum ada data laporan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
