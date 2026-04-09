@extends('layouts.user')

@section('page-title', 'Form Peminjaman')
@section('page-subtitle', 'Isi data untuk meminjam buku')

@section('content')
    <div class="flex gap-6 animate-fade-in-up">

        {{-- Card Buku --}}
        <div class="w-1/3 space-y-5">
            .
                <div class="p-5">
                    <h3 class="font-bold text-lg text-slate-800">{{ $buku['judul'] }}</h3>

                    <div class="mt-3 space-y-2">
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="fa-solid fa-tag text-xs text-[#14B8A6]"></i>
                            {{ $buku['kategori']['nama'] ?? '-' }}
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="fa-solid fa-user-pen text-xs text-blue-400"></i>
                            {{ $buku['penulis'] ?? '-' }}
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="fa-solid fa-building text-xs text-violet-400"></i>
                            {{ $buku['penerbit'] ?? '-' }}
                        </div>
                        <div class="flex items-center gap-2 text-sm text-slate-500">
                            <i class="fa-solid fa-boxes text-xs text-green-400"></i>
                            Stok: {{ $buku['stok'] }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ulasan Section --}}
            @if(isset($ulasans) && count($ulasans) > 0)
                <div class="bg-[#F3F4F6] rounded-2xl p-5">
                    <h4 class="font-semibold text-sm text-slate-700 mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-comments text-amber-400"></i>
                        Ulasan Pengguna ({{ count($ulasans) }})
                    </h4>
                    <div class="space-y-4 max-h-80 overflow-y-auto custom-scrollbar">
                        @foreach($ulasans as $u)
                            <div class="border-b border-slate-100 pb-3 last:border-0">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-semibold text-slate-700">{{ $u->user->name ?? 'Anonim' }}</span>
                                    <div class="flex text-amber-400 text-[10px] gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $u->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-solid fa-star text-slate-200"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-xs text-slate-500 leading-relaxed">{{ $u->ulasan }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-[#F3F4F6] rounded-2xl p-5 text-center">
                    <i class="fa-solid fa-comment-dots text-slate-200 text-3xl mb-2"></i>
                    <p class="text-xs text-slate-400">Belum ada ulasan untuk buku ini</p>
                </div>
            @endif
        </div>

        {{-- Form Peminjaman --}}
        <div class="flex-1 bg-[#F3F4F6] rounded-2xl p-7">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-[#14B8A6]/10 rounded-xl flex items-center justify-center">
                    <i class="fa-solid fa-file-pen text-[#14B8A6]"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-800">Form Peminjaman</h2>
                    <p class="text-xs text-slate-400">Lengkapi data di bawah untuk mengajukan peminjaman</p>
                </div>
            </div>

            <form method="POST" action="{{ route('user.peminjaman.submit') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="buku_id" value="{{ $buku['id'] }}">
                <input type="hidden" name="judul" value="{{ $buku['judul'] }}">
                <input type="hidden" name="penulis" value="{{ $buku['penulis'] ?? '' }}">
                <input type="hidden" name="penerbit" value="{{ $buku['penerbit'] ?? '' }}">

                {{-- Info buku (readonly) --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Judul Buku</label>
                        <input type="text" value="{{ $buku['judul'] }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 text-slate-500" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Penulis</label>
                        <input type="text" value="{{ $buku['penulis'] ?? '-' }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 text-slate-500" readonly>
                    </div>
                </div>

                <hr class="border-slate-100">

                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Data Peminjam</p>

                {{-- Form user --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition"
                            placeholder="Masukkan nama lengkap">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Kelas</label>
                        <input type="text" name="kelas" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition"
                            placeholder="Contoh: XII">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jurusan</label>
                        <input type="text" name="jurusan" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition"
                            placeholder="Contoh: PPLG">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">No HP</label>
                        <input type="text" name="no_hp" required
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition"
                            placeholder="08xxxxxxxxxx">
                    </div>
                </div>

                <hr class="border-slate-100">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal Pinjam</label>
                        <input type="date" name="tanggal_pinjam" value="{{ $tanggal_pinjam }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 text-slate-500" readonly>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" value="{{ $tanggal_kembali }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm bg-slate-50 text-slate-500" readonly>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Jumlah Buku</label>
                    <input type="number" name="jumlah" value="1" min="1" max="{{ $buku['stok'] }}" required
                        class="w-full border border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition"
                        placeholder="Masukkan jumlah buku">
                </div>

                <button type="submit"
                    class="w-full bg-[#14B8A6] text-white py-3 rounded-xl hover:bg-teal-600 hover:shadow-lg hover:shadow-teal-500/25 transition-all duration-300 font-semibold text-sm mt-2">
                    <i class="fa-solid fa-paper-plane mr-2"></i>
                    Ajukan Peminjaman
                </button>
            </form>
        </div>

    </div>
@endsection
