@extends('layouts.admin')

@section('page-title', 'Riwayat Peminjaman')
@section('page-subtitle', 'Data buku yang telah dikembalikan')

@section('content')
    <div class="animate-fade-in-up">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-700 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Nama User</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Judul Buku</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Tgl Pinjam</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Tgl Kembali</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($riwayat as $i => $r)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700">{{ $r->user->name ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-600">{{ $r->buku->judul ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $r->tanggal_pinjam }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $r->tanggal_kembali }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                        <i class="fa-solid fa-circle-check text-[10px]"></i> Dikembalikan
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12">
                                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-3">
                                        <i class="fa-solid fa-inbox text-slate-300 text-xl"></i>
                                    </div>
                                    <p class="text-slate-400 text-sm">Belum ada riwayat peminjaman</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
