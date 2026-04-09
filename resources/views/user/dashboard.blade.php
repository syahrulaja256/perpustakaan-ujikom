@extends('layouts.user')

@section('page-title', 'Beranda')
@section('page-subtitle', 'Temukan dan pinjam buku favoritmu')

@section('content')
    <div class="space-y-6">

        {{-- Welcome Banner --}}
        <div class="bg-[#14B8A6] rounded-2xl p-6 relative overflow-hidden animate-fade-in-up">
            <div class="absolute -top-6 -right-6 w-32 h-32 bg-white/10 rounded-full"></div>
            <div class="absolute bottom-0 right-20 w-20 h-20 bg-white/5 rounded-full"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-white mb-1">Hai, {{ Auth::user()->name }}! 📚</h3>
                    <p class="text-white/80 text-sm">Temukan buku favoritmu dan mulai membaca hari ini.</p>
                </div>
                <div class="hidden lg:flex items-center gap-3">
                    <div class="bg-white/15 backdrop-blur-sm rounded-xl px-4 py-2 border border-white/10">
                        <p class="text-white/70 text-[10px] uppercase tracking-wider font-semibold">Total Koleksi</p>
                        <p class="text-white text-lg font-bold">{{ count($bukus) }} Buku</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Search --}}
        <div class="bg-[#F3F4F6] rounded-2xl p-5 animate-fade-in-up">
            <form method="GET" action="{{ route('user.dashboard') }}">
                <div class="flex gap-3">
                    <div class="flex-1 relative">
                        <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari judul buku, penulis, atau kategori..."
                            class="w-full bg-white border border-gray-200 rounded-xl pl-11 pr-4 py-3 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition">
                    </div>
                    <button class="bg-[#14B8A6] text-white px-7 py-3 rounded-xl hover:bg-teal-600 hover:shadow-lg hover:shadow-teal-500/25 transition-all duration-300 text-sm font-semibold">
                        <i class="fa-solid fa-search mr-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>

        {{-- Book Count --}}
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-500">
                Menampilkan <span class="font-semibold text-gray-700">{{ count($bukus) }}</span> buku
            </p>
        </div>

        {{-- Grid Buku --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            @foreach ($bukus as $index => $b)
                @php
                    $rating = round($b->rating_avg ?? 0, 1);
                    $ratingInt = floor($rating);
                    $bukuUlasans = $b->peminjaman->filter(fn($p) => $p->rating && $p->ulasan);
                @endphp
                <div class="bg-[#F3F4F6] rounded-2xl overflow-hidden card-hover animate-fade-in-up stagger-{{ ($index % 8) + 1 }} group/card">

                    {{-- Cover --}}
                  <div class="relative w-full aspect-[3/4] overflow-hidden rounded-t-2xl">
    <img src="{{ asset('storage/' . $b->cover) }}"
         class="w-full h-full object-cover group-hover/card:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover/card:opacity-100 transition-opacity duration-300"></div>

                        {{-- Kategori Badge --}}
                        <div class="absolute top-3 left-3">
                            <span class="text-[10px] font-semibold bg-[#14B8A6] text-white px-3 py-1.5 rounded-lg shadow-sm">
                                {{ $b->kategori->nama ?? '-' }}
                            </span>
                        </div>

                        {{-- Favorite Button --}}
                        <form action="{{ route('user.favorite.add') }}" method="POST"
                            class="absolute top-3 right-3 opacity-0 group-hover/card:opacity-100 transition-opacity duration-300">
                            @csrf
                            <input type="hidden" name="buku_id" value="{{ $b->id }}">
                            <button class="w-9 h-9 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center hover:bg-[#14B8A6] hover:text-white transition-all duration-300 shadow-sm text-gray-500">
                                <i class="fa-regular fa-heart text-sm"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Info --}}
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 text-sm leading-tight line-clamp-2 min-h-[2.5rem]">
                            {{ $b->judul }}
                        </h3>

                        <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-user-pen text-[10px] text-[#14B8A6]"></i>
                            {{ $b->penulis }}
                        </p>

                        <p class="text-xs text-gray-400 mt-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-boxes text-xs text-green-400"></i>
                             Stok: {{ $b->stok > 0 ? $b->stok : 'kosong' }}
                        </p>
                        
                        

                        {{-- Rating --}}
                        <div class="flex items-center gap-2 mt-3">
                            <div class="flex text-amber-400 text-xs gap-0.5">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $ratingInt)
                                        <i class="fa-solid fa-star"></i>
                                    @else
                                        <i class="fa-solid fa-star text-gray-200"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-xs text-gray-400">
                                {{ $rating > 0 ? number_format($rating, 1) : '0' }}
                                ({{ $b->total_ulasan ?? 0 }})
                            </span>
                        </div>

                        {{-- Lihat Ulasan Button --}}
                        @if($bukuUlasans->count() > 0)
                            <button onclick="openUlasanModal({{ $b->id }})"
                                class="mt-2 w-full text-center text-xs text-[#14B8A6] hover:text-teal-700 font-semibold py-1.5 rounded-lg hover:bg-teal-50 transition-all duration-300 cursor-pointer">
                                <i class="fa-solid fa-comments mr-1"></i>
                                Lihat {{ $bukuUlasans->count() }} Ulasan
                            </button>
                        @else
                            <p class="mt-2 text-center text-xs text-gray-300 py-1.5">
                                <i class="fa-solid fa-comment-dots mr-1"></i> Belum ada ulasan
                            </p>
                        @endif

                        {{-- Button Pinjam --}}
                        <a href="{{ route('user.peminjaman.form', $b->id) }}"
                            class="mt-2 block text-center bg-[#14B8A6] text-white text-sm py-2.5 rounded-xl hover:bg-teal-600 hover:shadow-lg hover:shadow-teal-500/25 transition-all duration-300 font-semibold">
                            <i class="fa-solid fa-hand-holding-heart mr-1.5 text-xs"></i>
                            Pinjam
                        </a>
                    </div>

                </div>

                {{-- Hidden Ulasan Data for Modal --}}
                <div id="ulasan-data-{{ $b->id }}" class="hidden" data-judul="{{ $b->judul }}" data-rating="{{ $rating }}" data-total="{{ $bukuUlasans->count() }}">
                    @foreach($bukuUlasans as $u)
                        <div class="ulasan-item" data-name="{{ $u->user->name ?? 'Anonim' }}" data-rating="{{ $u->rating }}" data-text="{{ $u->ulasan }}" data-date="{{ $u->updated_at->format('d M Y') }}"></div>
                    @endforeach
                </div>
            @endforeach

        </div>

        @if (count($bukus) === 0)
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto bg-[#F3F4F6] rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-book-open text-gray-300 text-2xl"></i>
                </div>
                <p class="text-gray-400 text-sm">Tidak ada buku ditemukan</p>
            </div>
        @endif

    </div>

    {{-- MODAL ULASAN --}}
    <div id="ulasan-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4 overflow-hidden animate-fade-in-up max-h-[85vh] flex flex-col">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-amber-500 to-orange-500 p-6 relative overflow-hidden flex-shrink-0">
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-white/10 rounded-full"></div>
                <div class="relative z-10">
                    <h3 id="modal-judul" class="text-lg font-bold text-white"></h3>
                    <div class="flex items-center gap-3 mt-2">
                        <div class="flex text-white text-sm gap-0.5" id="modal-stars"></div>
                        <span id="modal-rating-text" class="text-white/80 text-sm font-semibold"></span>
                    </div>
                </div>
            </div>

            {{-- Ulasan List --}}
            <div class="p-6 overflow-y-auto flex-1 custom-scrollbar" id="modal-ulasan-list">
                {{-- Filled by JS --}}
            </div>

            {{-- Footer --}}
            <div class="px-6 pb-6 flex-shrink-0">
                <button onclick="closeUlasanModal()"
                    class="w-full py-2.5 bg-slate-100 text-slate-600 hover:bg-slate-200 rounded-xl text-sm font-medium transition cursor-pointer">
                    <i class="fa-solid fa-xmark mr-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
        function openUlasanModal(bukuId) {
            const dataEl = document.getElementById('ulasan-data-' + bukuId);
            const judul = dataEl.dataset.judul;
            const rating = parseFloat(dataEl.dataset.rating);
            const total = parseInt(dataEl.dataset.total);

            // Set header
            document.getElementById('modal-judul').textContent = judul;
            document.getElementById('modal-rating-text').textContent = rating.toFixed(1) + ' (' + total + ' ulasan)';

            // Stars
            let starsHtml = '';
            for (let i = 1; i <= 5; i++) {
                starsHtml += i <= Math.floor(rating)
                    ? '<i class="fa-solid fa-star"></i>'
                    : '<i class="fa-solid fa-star text-white/30"></i>';
            }
            document.getElementById('modal-stars').innerHTML = starsHtml;

            // Ulasan items
            const items = dataEl.querySelectorAll('.ulasan-item');
            let listHtml = '';
            items.forEach(function(item) {
                const name = item.dataset.name;
                const uRating = parseInt(item.dataset.rating);
                const text = item.dataset.text;
                const date = item.dataset.date;

                let itemStars = '';
                for (let i = 1; i <= 5; i++) {
                    itemStars += i <= uRating
                        ? '<i class="fa-solid fa-star text-amber-400"></i>'
                        : '<i class="fa-solid fa-star text-slate-200"></i>';
                }

                listHtml += `
                    <div class="border-b border-slate-100 pb-4 mb-4 last:border-0 last:mb-0 last:pb-0">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-teal-400 to-emerald-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                    ${name.charAt(0).toUpperCase()}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-slate-700">${name}</p>
                                    <p class="text-[10px] text-slate-400">${date}</p>
                                </div>
                            </div>
                            <div class="flex text-[10px] gap-0.5">${itemStars}</div>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed pl-10">${text}</p>
                    </div>
                `;
            });

            document.getElementById('modal-ulasan-list').innerHTML = listHtml;

            // Show modal
            const modal = document.getElementById('ulasan-modal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeUlasanModal() {
            const modal = document.getElementById('ulasan-modal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close on backdrop click
        document.getElementById('ulasan-modal').addEventListener('click', function(e) {
            if (e.target === this) closeUlasanModal();
        });
    </script>
@endsection
