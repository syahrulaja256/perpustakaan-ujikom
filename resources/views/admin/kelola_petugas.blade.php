@extends('layouts.admin')

@section('page-title', 'Kelola Petugas')
@section('page-subtitle', 'Tambah dan kelola petugas perpustakaan')

@section('content')
    <div class="space-y-5 animate-fade-in-up">

        {{-- Form Tambah Petugas --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-indigo-500"></i> Tambah Petugas Baru
            </h3>
            <form method="POST" action="{{ route('admin.petugas.store') }}">
                @csrf
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama</label>
                        <input type="text" name="name" placeholder="Nama lengkap" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                        <input type="email" name="email" placeholder="email@example.com" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password</label>
                        <input type="password" name="password" placeholder="Min 6 karakter" required minlength="6"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition">
                    </div>
                </div>
                <div class="mt-4">
                    <button type="submit"
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-violet-500 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-indigo-500/30 transition-all duration-300">
                        <i class="fa-solid fa-plus"></i> Tambah Petugas
                    </button>
                </div>
            </form>

            @if($errors->any())
                <div class="mt-3 bg-red-50 text-red-600 rounded-xl p-3 text-xs">
                    @foreach($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Tabel Petugas --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-700 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Nama</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Email</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($petugas as $i => $p)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($p->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-slate-700">{{ $p->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $p->email }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    <form action="{{ route('admin.petugas.hapus', $p->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus petugas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                            <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-12">
                                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-3">
                                        <i class="fa-solid fa-user-tie text-slate-300 text-xl"></i>
                                    </div>
                                    <p class="text-slate-400 text-sm">Belum ada petugas</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
