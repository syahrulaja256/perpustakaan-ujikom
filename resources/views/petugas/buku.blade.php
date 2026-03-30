@extends('layouts.petugas')

@section('page-title', 'Data Buku')
@section('page-subtitle', 'Kelola data buku perpustakaan')

@section('content')
    <div class="space-y-5 animate-fade-in-up">

        {{-- Header --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-slate-500">Total <span class="font-semibold text-slate-700">{{ count($bukus) }}</span> buku</p>
            <a href="{{ route('petugas.buku') }}?tambah=1"
                class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-cyan-500/30 transition-all duration-300">
                <i class="fa-solid fa-plus"></i> Tambah Buku
            </a>
        </div>

        {{-- Form Tambah --}}
        @if (request('tambah'))
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <h3 class="text-sm font-semibold text-slate-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-plus text-cyan-500"></i> Tambah Buku Baru
                </h3>
                <form method="POST" action="{{ route('petugas.buku.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Judul</label>
                            <input type="text" name="judul" placeholder="Judul buku" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penulis</label>
                            <input type="text" name="penulis" placeholder="Penulis" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penerbit</label>
                            <input type="text" name="penerbit" placeholder="Penerbit" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit" placeholder="2024" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 focus:outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kategori</label>
                            <select name="kategori_id" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-cyan-400 focus:border-cyan-400 focus:outline-none transition">
                                <option value="">Pilih Kategori</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Cover</label>
                            <input type="file" name="cover"
                                class="w-full border border-slate-200 rounded-xl px-4 py-2 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-cyan-50 file:text-cyan-500">
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button type="submit"
                            class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-500 to-blue-500 text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:shadow-lg transition-all">
                            <i class="fa-solid fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('petugas.buku') }}" class="bg-slate-200 hover:bg-slate-300 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-semibold transition">Batal</a>
                    </div>
                </form>
                @if($errors->any())
                    <div class="mt-3 bg-red-50 text-red-600 rounded-xl p-3 text-xs">
                        @foreach($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
                    </div>
                @endif
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($bukus as $buku)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3 text-sm text-slate-500">{{ $loop->iteration }}</td>
                                <td class="px-5 py-3">
                                    @if($buku->cover)
                                        <img src="{{ asset('storage/' . $buku->cover) }}" class="w-10 h-14 rounded-lg object-cover shadow-sm">
                                    @else
                                        <div class="w-10 h-14 bg-slate-100 rounded-lg flex items-center justify-center">
                                            <i class="fa-solid fa-image text-slate-300 text-xs"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-sm font-medium text-slate-700">{{ $buku->judul }}</td>
                                <td class="px-5 py-3 text-sm text-slate-500">{{ $buku->penulis }}</td>
                                <td class="px-5 py-3 text-sm text-slate-500">{{ $buku->penerbit }}</td>
                                <td class="px-5 py-3 text-sm text-slate-500">{{ $buku->tahun_terbit }}</td>
                                <td class="px-5 py-3"><span class="text-xs bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg font-medium">{{ $buku->kategori->nama ?? '-' }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-12">
                                    <div class="w-16 h-16 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-3"><i class="fa-solid fa-book text-slate-300 text-xl"></i></div>
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
