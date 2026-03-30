@extends('layouts.user')

@section('page-title', 'Ulasan & Kembalikan Buku')
@section('page-subtitle', 'Berikan ulasan sebelum mengembalikan buku')

@section('content')
    <div class="max-w-xl mx-auto animate-fade-in-up">

        <div class="bg-[#F3F4F6] rounded-2xl overflow-hidden">

            {{-- Book Info --}}
            <div class="bg-[#14B8A6] p-6 relative overflow-hidden">
                <div class="flex gap-5">
                    <img src="{{ asset('storage/' . $data->buku->cover) }}"
                        class="w-20 h-28 object-cover rounded-xl shadow-lg" onerror="this.style.display='none'">
                    <div class="text-white">
                        <h3 class="text-lg font-bold">{{ $data->buku->judul }}</h3>
                        <p class="text-slate-300 text-sm mt-1">{{ $data->buku->penulis }}</p>
                        <div class="mt-3 flex items-center gap-2">
                            <span class="bg-white/10 text-xs px-3 py-1 rounded-lg">
                                {{ $data->buku->kategori->nama ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Info Banner --}}
            <div class="mx-6 mt-6 bg-amber-50 border border-amber-200 rounded-xl p-4 flex items-start gap-3">
                <i class="fa-solid fa-info-circle text-amber-500 mt-0.5"></i>
                <p class="text-xs text-amber-700 leading-relaxed">
                    Setelah mengirim ulasan, buku akan otomatis diajukan untuk pengembalian dan menunggu konfirmasi admin/petugas.
                </p>
            </div>

            {{-- Form --}}
            <form action="{{ route('user.ulasan.submit') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" name="peminjaman_id" value="{{ $data->id }}">
                <input type="hidden" name="rating" id="rating-input" value="0">

                {{-- Star Rating --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-3">
                        <i class="fa-solid fa-star text-amber-400 mr-1"></i> Rating Buku
                    </label>
                    <div class="flex gap-2" id="star-rating">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="star cursor-pointer text-3xl text-slate-200 hover:text-amber-400 transition-colors select-none"
                                data-value="{{ $i }}"
                                onclick="setRating({{ $i }})">★</span>
                        @endfor
                    </div>
                    <p class="text-xs text-slate-400 mt-2" id="rating-text">Klik bintang untuk memberi rating</p>
                </div>

                {{-- Ulasan --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">
                        <i class="fa-solid fa-pen text-[#14B8A6] mr-1"></i> Tulis Ulasan
                    </label>
                    <textarea name="ulasan" rows="4"
                        placeholder="Ceritakan pengalaman kamu membaca buku ini..."
                        class="w-full bg-white border border-gray-200 rounded-xl p-4 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition resize-none"></textarea>
                </div>

                {{-- Button --}}
                <button type="submit"
                    class="w-full bg-orange-500 text-white py-3 rounded-xl hover:bg-orange-600 hover:shadow-lg hover:shadow-orange-500/25 transition-all duration-300 font-semibold text-sm">
                    <i class="fa-solid fa-paper-plane mr-2"></i>
                    Kirim Ulasan & Kembalikan Buku
                </button>
            </form>

        </div>

    </div>

    <script>
        const stars = document.querySelectorAll('#star-rating .star');
        const ratingInput = document.getElementById('rating-input');
        const ratingText = document.getElementById('rating-text');
        const labels = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Bagus', 'Sangat Bagus'];

        function setRating(val) {
            ratingInput.value = val;
            stars.forEach((star, index) => {
                if (index < val) {
                    star.style.color = '#f59e0b'; // amber-400
                } else {
                    star.style.color = '#e2e8f0'; // slate-200
                }
            });
            ratingText.textContent = labels[val] + ' (' + val + '/5)';
            ratingText.style.color = '#f59e0b';
        }

        // Hover effect
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', () => {
                stars.forEach((s, i) => {
                    s.style.color = i <= index ? '#fbbf24' : '#e2e8f0';
                });
            });
        });

        document.getElementById('star-rating').addEventListener('mouseleave', () => {
            const val = parseInt(ratingInput.value);
            stars.forEach((star, index) => {
                star.style.color = index < val ? '#f59e0b' : '#e2e8f0';
            });
        });
    </script>
@endsection
