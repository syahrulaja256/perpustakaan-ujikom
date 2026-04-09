@php
    $role = Auth::user()->role;
    if ($role == 'admin') {
        $layout = 'layouts.admin';
    } elseif ($role == 'petugas') {
        $layout = 'layouts.petugas';
    } else {
        $layout = 'layouts.user';
    }
@endphp

@extends($layout)

@section('page-title', 'Profil Saya')
@section('page-subtitle', 'Kelola informasi akun Anda')

@section('content')
    <div class="max-w-2xl mx-auto animate-fade-in-up">

        <div class="bg-[#F3F4F6] rounded-2xl overflow-hidden">

            {{-- Header --}}
            <div class="bg-[#14B8A6] p-8 text-center relative overflow-hidden">
                <div class="absolute -top-6 -right-6 w-32 h-32 bg-white/10 rounded-full"></div>
                <div class="absolute bottom-0 left-10 w-20 h-20 bg-white/5 rounded-full"></div>
                <div class="relative z-10">
                    <div class="w-20 h-20 mx-auto bg-white rounded-full flex items-center justify-center text-3xl font-bold text-[#14B8A6] shadow-lg mb-4">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-bold text-white">{{ $user->name }}</h2>
                    <p class="text-white/80 text-sm mt-1">{{ $user->email }}</p>
                    <p class="text-white/80 text-sm mt-1">{{ $user->alamat }}</p>
                    <span class="inline-flex items-center gap-1 bg-white/20 text-white text-xs px-3 py-1 rounded-full mt-3 font-semibold border border-white/10">
                        <i class="fa-solid fa-{{ $user->role == 'admin' ? 'shield-halved' : ($user->role == 'petugas' ? 'user-tie' : 'user') }} text-[10px]"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            {{-- Form --}}
            <form action="{{ route('profile.update') }}" method="POST" class="p-7 space-y-5">
                @csrf

                @if (session('success'))
                    <div class="bg-teal-50 border border-teal-200 text-teal-600 rounded-xl p-3 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-3 text-xs">
                        @foreach($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">
                        <i class="fa-solid fa-user text-[#14B8A6] mr-1"></i> Nama Lengkap
                    </label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">
                        <i class="fa-solid fa-envelope text-[#14B8A6] mr-1"></i> Email
                    </label>
                    <input type="email" name="email" value="{{ $user->email }}" required
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-600 mb-2">
                        <i class="fa-solid fa-home text-[#14B8A6] mr-1"></i> Alamat
                    </label>
                    <input type="text" name="alamat" value="{{ $user->alamat }}" required
                        class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition">
                </div>


                <hr class="border-gray-200">

                <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Ganti Password <span class="font-normal text-gray-400">(opsional)</span></p>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2">
                            <i class="fa-solid fa-lock text-[#14B8A6] mr-1"></i> Password Baru
                        </label>
                        <input type="password" name="password" placeholder="Min 6 karakter"
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-2">
                            <i class="fa-solid fa-shield-halved text-[#14B8A6] mr-1"></i> Konfirmasi Password
                        </label>
                        <input type="password" name="password_confirmation" placeholder="Ulangi password"
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition">
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-[#14B8A6] text-white py-3.5 rounded-xl hover:bg-teal-600 hover:shadow-lg hover:shadow-teal-500/30 transition-all duration-300 font-semibold text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-save"></i>
                    Simpan Perubahan
                </button>
            </form>

        </div>

    </div>
@endsection
