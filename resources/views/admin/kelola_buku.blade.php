@extends('layouts.admin')

@section('page-title', 'Kelola Buku')
@section('page-subtitle', 'Tambah, edit, dan hapus data buku')

@section('content')
    <div class="space-y-5 animate-fade-in-up">

        {{-- Tombol Tambah --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">
                Total <span class="font-semibold text-slate-700">{{ count($bukus) }}</span> buku
            </p>
            <a href="{{ route('admin.kelola_buku') }}?tambah=1"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-indigo-500 to-violet-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-indigo-500/30 transition-all duration-300">
                <i class="fa-solid fa-plus"></i>
                Tambah Buku
            </a>
        </div>

        {{-- Form Tambah/Edit --}}
        @if (request('tambah') || isset($buku))
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-base font-semibold text-slate-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-{{ isset($buku) ? 'pen' : 'plus' }} text-indigo-500"></i>
                    {{ isset($buku) ? 'Edit Buku' : 'Tambah Buku Baru' }}
                </h3>

                <form action="{{ isset($buku) ? route('admin.bukus.update', $buku->id) : route('admin.bukus.store') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Judul Buku</label>
                            <input type="text" name="judul" placeholder="Judul Buku" value="{{ $buku->judul ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penulis</label>
                            <input type="text" name="penulis" placeholder="Penulis" value="{{ $buku->penulis ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penerbit</label>
                            <input type="text" name="penerbit" placeholder="Penerbit" value="{{ $buku->penerbit ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" placeholder="Tahun" value="{{ $buku->tahun_terbit ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kategori</label>
                            <select name="kategori_id"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($kategoris as $k)
                                    <option value="{{ $k->id }}" @if (isset($buku) && $buku->kategori_id == $k->id) selected @endif>
                                        {{ $k->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Stok</label>
                            <input type="number" name="stok" placeholder="Jumlah Stok" value="{{ $buku->stok ?? '' }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 focus:outline-none transition" required min="0">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Cover</label>
                            <input type="file" name="cover"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-500 hover:file:bg-indigo-100">
                        </div>
                    </div>

                    <div class="mt-5 flex gap-2">
                        <button class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">
                            <i class="fa-solid fa-save mr-1"></i> Simpan
                        </button>
                        <a href="{{ route('admin.kelola_buku') }}"
                            class="bg-slate-200 hover:bg-slate-300 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold transition">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-700 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Cover</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Judul</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Penulis</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Penerbit</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Tahun</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Kategori</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Stok</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($bukus as $i => $b)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3">
                                    @if ($b->cover)
                                        <img src="{{ asset('storage/' . $b->cover) }}" class="w-10 h-14 rounded-lg object-cover shadow-sm">
                                    @else
                                        <div class="w-10 h-14 bg-slate-100 rounded-lg flex items-center justify-center">
                                            <i class="fa-solid fa-image text-slate-300 text-xs"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-sm font-medium text-slate-700">{{ $b->judul }}</td>
                                <td class="px-5 py-3 text-sm text-slate-500">{{ $b->penulis }}</td>
                                <td class="px-5 py-3 text-sm text-slate-500">{{ $b->penerbit }}</td>
                                <td class="px-5 py-3 text-sm text-slate-500">{{ $b->tahun_terbit }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg font-medium">
                                        {{ $b->kategori ? $b->kategori->nama : '-' }}
                                    </span>
                                </td>
                                <td class="px-5 py-3 text-sm text-slate-500">{{ $b->stok }}</td>
                                <td class="px-5 py-3 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.bukus.edit', $b->id) }}"
                                            class="inline-flex items-center gap-1 bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                            <i class="fa-solid fa-pen text-[10px]"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.bukus.destroy', $b->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Yakin hapus buku?')"
                                                class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                                <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-12">
                                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-3">
                                        <i class="fa-solid fa-book text-slate-300 text-xl"></i>
                                    </div>
                                    <p class="text-slate-400 text-sm">Belum ada buku</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
