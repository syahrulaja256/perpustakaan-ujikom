@extends('layouts.admin')

@section('page-title', 'Peminjaman Buku')
@section('page-subtitle', 'Kelola persetujuan peminjaman & pengembalian')

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
                            <th class="px-5 py-4 text-center text-xs font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($peminjamans as $i => $p)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700">{{ $p->user->name ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-600">{{ $p->buku->judul ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $p->tanggal_pinjam }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $p->tanggal_kembali }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    @if ($p->status == 'Menunggu')
                                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-clock text-[10px]"></i> Menunggu
                                        </span>
                                    @elseif($p->status == 'Dikonfirmasi')
                                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-check text-[10px]"></i>
                                            Dikonfirmasi
                                            @if($p->dikonfirmasi_oleh)
                                                <span class="text-blue-400">({{ ucfirst($p->dikonfirmasi_oleh) }})</span>
                                            @endif
                                        </span>
                                    @elseif($p->status == 'Menunggu Pengembalian')
                                        <span class="inline-flex items-center gap-1 bg-orange-50 text-orange-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-hourglass-half text-[10px]"></i> Minta Kembali
                                        </span>
                                    @elseif($p->status == 'Dikembalikan')
                                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i> Dikembalikan
                                        </span>
                                    @elseif($p->status == 'Ditolak')
                                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-xmark text-[10px]"></i> Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">
                                        {{-- Terima Peminjaman --}}
                                        @if ($p->status == 'Menunggu')
                                            <a href="{{ route('admin.peminjaman.konfirmasi', $p->id) }}"
                                                class="inline-flex items-center gap-1 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                                <i class="fa-solid fa-check text-[10px]"></i> Terima Peminjaman
                                            </a>
                                        @endif

                                        {{-- Cetak Peminjaman (saat sudah dikonfirmasi) --}}
                                        @if ($p->status == 'Dikonfirmasi')
                                            <a href="{{ route('admin.cetak.peminjaman', $p->id) }}" target="_blank"
                                                class="inline-flex items-center gap-1 bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                                <i class="fa-solid fa-file-pdf text-[10px]"></i> Cetak Peminjaman
                                            </a>
                                        @endif

                                        {{-- Terima Pengembalian --}}
                                        @if ($p->status == 'Menunggu Pengembalian')
                                            <form action="{{ route('admin.peminjaman.konfirmasi_pengembalian', $p->id) }}" method="POST">
                                                @csrf
                                                <button class="inline-flex items-center gap-1 bg-teal-500 hover:bg-teal-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                                    <i class="fa-solid fa-circle-check text-[10px]"></i> Terima Pengembalian
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Cetak Pengembalian (struk) --}}
                                        @if ($p->status == 'Dikembalikan')
                                            <a href="{{ route('admin.cetak.pengembalian', $p->id) }}" target="_blank"
                                                class="inline-flex items-center gap-1 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                                <i class="fa-solid fa-file-pdf text-[10px]"></i> Cetak Pengembalian
                                            </a>
                                        @endif

                                        {{-- Status Ditolak --}}
                                        @if ($p->status == 'Ditolak')
                                            <span class="text-xs text-slate-400">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-3">
                                        <i class="fa-solid fa-inbox text-slate-300 text-xl"></i>
                                    </div>
                                    <p class="text-slate-400 text-sm">Belum ada peminjaman</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
