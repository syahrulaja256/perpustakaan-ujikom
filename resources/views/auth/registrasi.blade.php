<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi - Perpustakaan Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans relative overflow-hidden">

    {{-- Background --}}
    <div class="fixed inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
    <div class="fixed inset-0 opacity-20">
        <div class="absolute top-10 right-10 w-80 h-80 bg-[#14B8A6] rounded-full blur-[140px] animate-pulse"></div>
        <div class="absolute bottom-10 left-10 w-96 h-96 bg-teal-400 rounded-full blur-[160px] animate-pulse" style="animation-delay:1s"></div>
    </div>
    <div class="fixed inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 40px 40px;"></div>

    {{-- Content --}}
    <div class="relative z-10 min-h-screen flex items-center justify-center p-4">

        <div class="w-full max-w-md animate-fade-in-up">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 mx-auto bg-[#14B8A6] rounded-2xl flex items-center justify-center shadow-lg shadow-teal-500/30 mb-4">
                    <i class="fa-solid fa-user-plus text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-white">Buat Akun Baru</h1>
                <p class="text-slate-400 text-sm mt-1">Daftar untuk mulai meminjam buku</p>
            </div>

            {{-- Card --}}
            <div class="bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 shadow-2xl">

                @if (session('error'))
                    <div class="bg-red-500/10 border border-red-500/20 text-red-300 rounded-xl p-3 mb-5 text-sm flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-300 rounded-xl p-3 mb-5 text-xs">
                        @foreach($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('registrasi') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2 uppercase tracking-wider">Nama Lengkap</label>
                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="text" name="name" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl pl-11 pr-4 py-3.5 text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition"
                                placeholder="John Doe">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2 uppercase tracking-wider">Email</label>
                        <div class="relative">
                            <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="email" name="email" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl pl-11 pr-4 py-3.5 text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition"
                                placeholder="nama@email.com">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2 uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="password" name="password" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl pl-11 pr-4 py-3.5 text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition"
                                placeholder="Min 6 karakter">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-2 uppercase tracking-wider">Konfirmasi Password</label>
                        <div class="relative">
                            <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                            <input type="password" name="password_confirmation" required
                                class="w-full bg-white/5 border border-white/10 rounded-xl pl-11 pr-4 py-3.5 text-sm text-white placeholder-slate-500 focus:ring-2 focus:ring-[#14B8A6] focus:border-[#14B8A6] focus:outline-none transition"
                                placeholder="Ulangi password">
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-[#14B8A6] text-white py-3.5 rounded-xl font-semibold text-sm hover:bg-teal-600 hover:shadow-lg hover:shadow-teal-500/30 hover:scale-[1.02] transition-all duration-300 flex items-center justify-center gap-2 mt-2">
                        <i class="fa-solid fa-user-plus"></i>
                        Daftar Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-slate-400 text-sm">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-[#14B8A6] font-semibold hover:text-teal-300 transition">Masuk</a>
                    </p>
                </div>

            </div>

            <div class="text-center mt-6">
                <a href="/" class="text-slate-500 text-xs hover:text-white transition flex items-center justify-center gap-1">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    Kembali ke beranda
                </a>
            </div>

        </div>

    </div>

</body>
</html>
