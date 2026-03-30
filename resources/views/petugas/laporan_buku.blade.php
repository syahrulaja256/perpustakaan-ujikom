@extends('layouts.petugas')

@section('page-title', 'Laporan Buku')
@section('page-subtitle', 'Data seluruh buku perpustakaan')

@section('content')
    <div class="space-y-5 animate-fade-in-up">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Total <span class="font-semibold text-slate-700">{{ count($bukus) }}</span> buku</p>
            <a href="{{ route('petugas.cetak.laporan.buku') }}" target="_blank"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-file-pdf"></i> Cetak Laporan Buku
            </a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-700 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Judul</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Penulis</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Penerbit</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Tahun</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($bukus as $i => $b)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700">{{ $b->judul }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $b->penulis }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $b->penerbit }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $b->tahun_terbit }}</td>
                                <td class="px-5 py-3.5"><span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg font-medium">{{ $b->kategori->nama ?? '-' }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-12 text-slate-400 text-sm">Belum ada buku</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
