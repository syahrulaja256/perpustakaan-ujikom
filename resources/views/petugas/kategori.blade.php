@extends('layouts.petugas')

@section('page-title', 'Data Kategori')
@section('page-subtitle', 'Kelola kategori buku perpustakaan')

@section('content')
    <div class="space-y-5 animate-fade-in-up">

        {{-- Form Tambah Kategori --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-tag text-amber-500"></i> Tambah Kategori Baru
            </h3>
            <form method="POST" action="{{ route('petugas.kategori.store') }}" class="flex items-end gap-3">
                @csrf
                <div class="flex-1">
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Kategori</label>
                    <input type="text" name="nama" placeholder="Masukkan nama kategori" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 focus:outline-none transition">
                </div>
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                    <i class="fa-solid fa-plus"></i> Tambah
                </button>
            </form>
            @if($errors->any())
                <div class="mt-3 bg-red-50 text-red-600 rounded-xl p-3 text-xs">
                    @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
                </div>
            @endif
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <p class="text-sm text-slate-500">Total <span class="font-semibold text-slate-700">{{ count($kategoris) }}</span> kategori</p>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-700 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold w-16">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Nama Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($kategoris as $kategori)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3.5 text-sm font-medium text-slate-700">
                                    <span class="inline-flex items-center gap-2">
                                        <i class="fa-solid fa-tag text-amber-400 text-xs"></i>
                                        {{ $kategori->nama }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center py-12">
                                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-3"><i class="fa-solid fa-tags text-slate-300 text-xl"></i></div>
                                    <p class="text-slate-400 text-sm">Belum ada kategori</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
