@extends('layouts.admin')

@section('page-title', 'Laporan User')
@section('page-subtitle', 'Data seluruh pengguna terdaftar')

@section('content')
    <div class="space-y-5 animate-fade-in-up">
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Total <span class="font-semibold text-slate-700">{{ count($users) }}</span> user</p>
            <a href="{{ route('admin.cetak.laporan.user') }}" target="_blank"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-violet-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                <i class="fa-solid fa-file-pdf"></i> Cetak Laporan User
            </a>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-700 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Nama</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Email</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $i => $u)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-slate-700">{{ $u->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $u->email }}</td>
                                <td class="px-5 py-3.5 text-center text-sm text-slate-500">{{ $u->created_at ? $u->created_at->format('d/m/Y') : '-' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center py-12 text-slate-400 text-sm">Belum ada user</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
