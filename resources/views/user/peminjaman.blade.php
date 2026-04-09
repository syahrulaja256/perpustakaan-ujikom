@extends('layouts.user')

@section('page-title', 'Riwayat Peminjaman')
@section('page-subtitle', 'Daftar semua peminjaman buku kamu')

@section('content')
    <div class="animate-fade-in-up">

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-700 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Buku</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Jumlah</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Kelas</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Jurusan</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Tgl Pinjam</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Tgl Kembali</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold">Status</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pinjaman as $i => $p)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        @if($p->buku && $p->buku->cover)
                                            <img src="{{ asset('storage/' . $p->buku->cover) }}" class="w-9 h-12 rounded-lg object-cover shadow-sm">
                                        @endif
                                        <span class="text-sm font-medium text-slate-700">{{ $p->buku->judul ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $p->jumlah }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $p->kelas ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $p->jurusan ?? '-' }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $p->tanggal_pinjam }}</td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $p->tanggal_kembali }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    @if ($p->status == 'Menunggu')
                                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-clock text-[10px]"></i> Menunggu
                                        </span>
                                    @elseif($p->status == 'Dikonfirmasi')
                                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-check-circle text-[10px]"></i>
                                            Dipinjam
                                            @if($p->dikonfirmasi_oleh)
                                                <span class="text-blue-400">({{ ucfirst($p->dikonfirmasi_oleh) }})</span>
                                            @endif
                                        </span>
                                    @elseif($p->status == 'Menunggu Pengembalian')
                                        <span class="inline-flex items-center gap-1 bg-orange-50 text-orange-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-hourglass-half text-[10px]"></i> Menunggu Konfirmasi
                                        </span>
                                    @elseif($p->status == 'Ditolak')
                                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-xmark text-[10px]"></i> Ditolak
                                        </span>
                                    @elseif($p->status == 'Dikembalikan')
                                        <span class="inline-flex items-center gap-1 bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                            <i class="fa-solid fa-circle-check text-[10px]"></i> Dikembalikan
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <div class="flex items-center justify-center gap-2 flex-wrap">

                                        {{-- Cetak Peminjaman: saat sudah dikonfirmasi/dipinjam --}}
                                        @if (in_array($p->status, ['Dikonfirmasi', 'Menunggu Pengembalian', 'Dikembalikan']))
                                            <a href="{{ route('user.cetak.peminjaman', $p->id) }}" target="_blank"
                                                class="inline-flex items-center gap-1 bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                                <i class="fa-solid fa-file-pdf text-[10px]"></i> Cetak Pinjam
                                            </a>
                                        @endif

                                        {{-- Kembalikan Buku: saat status Dikonfirmasi (dipinjam) --}}
                                        @if ($p->status == 'Dikonfirmasi')
                                            <button onclick="openKembalikanModal({{ $p->id }})"
                                                class="inline-flex items-center gap-1 bg-orange-500 hover:bg-orange-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm cursor-pointer">
                                                <i class="fa-solid fa-rotate-left text-[10px]"></i> Kembalikan Buku
                                            </button>
                                        @endif

                                        {{-- Menunggu Pengembalian --}}
                                        @if ($p->status == 'Menunggu Pengembalian')
                                            <span class="inline-flex items-center gap-1 text-orange-500 text-xs font-semibold">
                                                <i class="fa-solid fa-hourglass-half"></i> Menunggu admin...
                                            </span>
                                        @endif

                                        {{-- Cetak Pengembalian: saat status Dikembalikan --}}
                                        @if ($p->status == 'Dikembalikan')
                                            <a href="{{ route('user.cetak.pengembalian', $p->id) }}" target="_blank"
                                                class="inline-flex items-center gap-1 bg-emerald-500 hover:bg-emerald-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                                <i class="fa-solid fa-file-pdf text-[10px]"></i> Cetak Kembali
                                            </a>
                                        @endif

                                        {{-- Sudah Diulas --}}
                                        @if ($p->status == 'Dikembalikan' && $p->rating != null)
                                            <span class="inline-flex items-center gap-1 text-emerald-500 text-xs font-semibold">
                                                <i class="fa-solid fa-circle-check"></i> Sudah diulas
                                            </span>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-12">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mb-3">
                                            <i class="fa-solid fa-inbox text-slate-300 text-xl"></i>
                                        </div>
                                        <p class="text-slate-400 text-sm">Belum ada riwayat peminjaman</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- MODAL KEMBALIKAN BUKU --}}
    <div id="kembalikan-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md mx-4 overflow-hidden animate-fade-in-up">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-orange-500 to-amber-500 p-6 relative overflow-hidden">
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
                <div class="relative z-10 text-center text-white">
                    <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i class="fa-solid fa-rotate-left text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-bold">Kembalikan Buku</h3>
                    <p class="text-white/80 text-sm mt-1">Apakah kamu ingin memberikan ulasan?</p>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-6 space-y-3">
                {{-- Berikan Ulasan --}}
                <a id="btn-dengan-ulasan" href="#"
                    class="flex items-center gap-4 p-4 bg-amber-50 hover:bg-amber-100 rounded-xl border border-amber-200 transition-all duration-300 group">
                    <div class="w-12 h-12 bg-amber-400 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-star text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-slate-700 text-sm">Berikan Ulasan</p>
                        <p class="text-xs text-slate-400">Tulis ulasan & rating sebelum kembalikan</p>
                    </div>
                    <i class="fa-solid fa-chevron-right text-slate-300 ml-auto"></i>
                </a>

                {{-- Tanpa Ulasan --}}
                <form id="form-tanpa-ulasan" method="POST" action="">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-4 p-4 bg-slate-50 hover:bg-slate-100 rounded-xl border border-slate-200 transition-all duration-300 group cursor-pointer">
                        <div class="w-12 h-12 bg-slate-400 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform">
                            <i class="fa-solid fa-forward text-white text-lg"></i>
                        </div>
                        <div class="text-left">
                            <p class="font-semibold text-slate-700 text-sm">Tanpa Ulasan</p>
                            <p class="text-xs text-slate-400">Langsung kembalikan buku</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-slate-300 ml-auto"></i>
                    </button>
                </form>
            </div>

            {{-- Footer --}}
            <div class="px-6 pb-6">
                <button onclick="closeKembalikanModal()"
                    class="w-full py-2.5 text-sm text-slate-500 hover:text-slate-700 font-medium transition cursor-pointer">
                    <i class="fa-solid fa-xmark mr-1"></i> Batal
                </button>
            </div>
        </div>
    </div>

    {{-- Auto download cetak peminjaman setelah submit --}}
    @if(session('auto_cetak'))
        <script>
            window.addEventListener('load', function() {
                setTimeout(function() {
                    window.open("{{ route('user.cetak.peminjaman', session('auto_cetak')) }}", '_blank');
                }, 1000);
            });
        </script>
    @endif

    <script>
        function openKembalikanModal(id) {
            const modal = document.getElementById('kembalikan-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Set link ulasan
            document.getElementById('btn-dengan-ulasan').href = '/user/kembalikan/' + id;

            // Set form tanpa ulasan
            document.getElementById('form-tanpa-ulasan').action = '/user/kembalikan/' + id;
        }

        function closeKembalikanModal() {
            const modal = document.getElementById('kembalikan-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal on backdrop click
        document.getElementById('kembalikan-modal').addEventListener('click', function(e) {
            if (e.target === this) closeKembalikanModal();
        });
    </script>
@endsection
