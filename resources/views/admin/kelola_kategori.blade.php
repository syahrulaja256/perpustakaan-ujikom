@extends('layouts.admin')

@section('page-title', 'Kelola Kategori')
@section('page-subtitle', 'Tambah dan kelola kategori buku')

@section('content')
    <div class="space-y-5 animate-fade-in-up">

        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-sm font-semibold text-slate-700 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-plus text-indigo-500"></i> Tambah Kategori Baru
            </h3>
            <form method="POST" action="{{ route('admin.kategori.store') }}" class="flex gap-3">
                @csrf
                <input type="text" name="nama" placeholder="Nama Kategori" required
                    class="flex-1 border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition">
                <button type="submit" class="bg-gradient-to-r from-indigo-500 to-violet-500 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                    <i class="fa-solid fa-save mr-1"></i> Simpan
                </button>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-700 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold w-16">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Nama Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($kategoris as $i => $kategori)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700">
                                    <span class="inline-flex items-center gap-2">
                                        <i class="fa-solid fa-tag text-amber-400 text-xs"></i>
                                        {{ $kategori['nama'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-12 text-slate-400 text-sm">Belum ada kategori</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
