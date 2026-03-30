@extends('layouts.user')

@section('page-title', 'Buku Favorit')
@section('page-subtitle', 'Koleksi buku yang kamu sukai')

@section('content')
    <div class="animate-fade-in-up">

        @if(count($favorites) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($favorites as $b)
                    <div class="bg-[#F3F4F6] rounded-2xl overflow-hidden card-hover">
                        <div class="relative overflow-hidden group">
                            <img src="{{ asset('storage/' . $b->cover) }}"
                                class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <div class="absolute top-3 left-3">
                                <span class="text-[10px] font-semibold bg-[#14B8A6] text-white px-3 py-1.5 rounded-lg shadow-sm">
                                    {{ $b->kategori->nama ?? '-' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-slate-800 text-sm leading-tight line-clamp-2 min-h-[2.5rem]">
                                {{ $b->judul }}
                            </h3>
                            <p class="text-xs text-slate-400 mt-1.5">{{ $b->penulis }}</p>

                            <div class="flex gap-2 mt-4">
                                <a href="{{ route('user.peminjaman.form', $b->id) }}"
                                    class="flex-1 text-center bg-[#14B8A6] text-white text-xs py-2.5 rounded-xl hover:bg-teal-600 hover:shadow-lg transition-all font-semibold">
                                    <i class="fa-solid fa-hand-holding-heart mr-1"></i> Pinjam
                                </a>
                                <form action="{{ route('user.favorite.remove', $b->id) }}" method="POST">
                                    @csrf
                                    <button class="w-10 h-10 bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-500 rounded-xl flex items-center justify-center transition">
                                        <i class="fa-solid fa-heart-crack text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto bg-[#F3F4F6] rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-heart text-slate-300 text-2xl"></i>
                </div>
                <p class="text-slate-400 text-sm">Belum ada buku favorit</p>
                <a href="{{ route('user.dashboard') }}" class="mt-3 inline-block text-[#14B8A6] text-sm font-semibold hover:underline">
                    Jelajahi buku →
                </a>
            </div>
        @endif

    </div>
@endsection
