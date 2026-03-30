@extends('layouts.user')

@section('page-title', 'Ulasan Saya')
@section('page-subtitle', 'Daftar ulasan yang telah kamu berikan')

@section('content')
    <div class="animate-fade-in-up">

        @if(count($ulasan) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($ulasan as $u)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 card-hover">
                        <div class="flex gap-4">
                            @if($u->buku && $u->buku->cover)
                                <img src="{{ asset('storage/' . $u->buku->cover) }}" class="w-16 h-20 object-cover rounded-xl shadow-sm">
                            @endif
                            <div class="flex-1">
                                <h4 class="font-semibold text-sm text-slate-800">{{ $u->buku->judul ?? '-' }}</h4>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $u->buku->penulis ?? '' }}</p>
                                <div class="flex text-amber-400 text-xs gap-0.5 mt-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $u->rating)
                                            <i class="fa-solid fa-star"></i>
                                        @else
                                            <i class="fa-solid fa-star text-slate-200"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 bg-slate-50 rounded-xl p-3">
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $u->ulasan }}</p>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-2">
                            <i class="fa-regular fa-clock mr-1"></i>
                            {{ $u->updated_at->diffForHumans() }}
                        </p>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="w-20 h-20 mx-auto bg-slate-100 rounded-2xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-pen text-slate-300 text-2xl"></i>
                </div>
                <p class="text-slate-400 text-sm">Belum ada ulasan yang diberikan</p>
                <a href="{{ route('user.dashboard') }}" class="mt-3 inline-block text-emerald-500 text-sm font-semibold hover:underline">
                    Mulai pinjam & review buku →
                </a>
            </div>
        @endif

    </div>
@endsection
