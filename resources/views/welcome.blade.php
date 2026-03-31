<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Perpustakaan Digital</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem perpustakaan digital modern untuk meningkatkan budaya literasi">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen overflow-x-hidden font-sans bg-white">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-lg border-b border-gray-100 px-8 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 bg-[#14B8A6] rounded-xl flex items-center justify-center shadow-lg shadow-teal-500/20">
                    <i class="fa-solid fa-book-open text-white text-lg"></i>
                </div>
                <h1 class="text-xl font-bold text-gray-800 tracking-wide">PERPUSTAKAAN</h1>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="px-6 py-2.5 text-sm font-semibold text-gray-600 hover:text-[#14B8A6] transition">
                    Login
                </a>
                <a href="{{ route('registrasi') }}"
                    class="px-6 py-2.5 text-sm font-semibold bg-[#14B8A6] text-white rounded-xl hover:bg-teal-600 transition-all duration-300 shadow-lg shadow-teal-500/20">
                    Register
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative overflow-hidden">
        {{-- Background decoration --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-[#14B8A6]/5 rounded-full -translate-y-1/2 translate-x-1/3"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-[#14B8A6]/5 rounded-full translate-y-1/2 -translate-x-1/3"></div>

        <div class="max-w-7xl mx-auto px-8 lg:px-16 py-20 lg:py-28">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-16">

                {{-- Left --}}
                <div class="max-w-xl animate-fade-in-up relative z-10">
                    <div class="inline-flex items-center gap-2 bg-[#14B8A6]/10 text-[#14B8A6] text-xs font-semibold px-4 py-2 rounded-full mb-6 border border-[#14B8A6]/20">
                        <i class="fa-solid fa-sparkles"></i>
                        Sistem Perpustakaan Digital Modern
                    </div>

                    <h2 class="text-5xl lg:text-6xl font-extrabold text-gray-800 leading-tight">
                        Membaca Adalah
                        <span class="text-[#14B8A6]">
                            Jendela Dunia
                        </span>
                    </h2>

                    <p class="mt-6 text-lg text-gray-500 leading-relaxed">
                        Meningkatkan budaya literasi melalui sistem perpustakaan digital yang
                        modern, efisien, dan mudah digunakan oleh semua pengguna.
                    </p>

                    <div class="mt-8 grid grid-cols-2 gap-3">
                        <div class="flex items-center gap-3 text-gray-600 text-sm">
                            <div class="w-8 h-8 bg-[#14B8A6]/10 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-check text-[#14B8A6] text-xs"></i>
                            </div>
                            Pendataan Buku & Kategori
                        </div>
                        <div class="flex items-center gap-3 text-gray-600 text-sm">
                            <div class="w-8 h-8 bg-[#14B8A6]/10 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-check text-[#14B8A6] text-xs"></i>
                            </div>
                            Peminjaman & Pengembalian
                        </div>
                        <div class="flex items-center gap-3 text-gray-600 text-sm">
                            <div class="w-8 h-8 bg-[#14B8A6]/10 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-check text-[#14B8A6] text-xs"></i>
                            </div>
                            Data Anggota Lengkap
                        </div>
                        <div class="flex items-center gap-3 text-gray-600 text-sm">
                            <div class="w-8 h-8 bg-[#14B8A6]/10 rounded-lg flex items-center justify-center">
                                <i class="fa-solid fa-check text-[#14B8A6] text-xs"></i>
                            </div>
                            Laporan Otomatis (PDF)
                        </div>
                    </div>

                    <div class="mt-10 flex gap-4">
                        <a href="{{ route('login') }}"
                            class="group px-8 py-3.5 bg-[#14B8A6] text-white rounded-xl font-semibold shadow-lg shadow-teal-500/25 hover:bg-teal-600 hover:shadow-teal-500/40 hover:scale-105 transition-all duration-300 flex items-center gap-2">
                            Mulai Sekarang
                            <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('registrasi') }}"
                            class="px-8 py-3.5 border border-gray-200 text-gray-700 rounded-xl font-semibold hover:bg-[#F3F4F6] transition-all duration-300">
                            Daftar Akun
                        </a>
                    </div>
                </div>

                {{-- Right: Stats Cards --}}
                <div class="grid grid-cols-2 gap-4 max-w-sm animate-fade-in-up relative z-10" style="animation-delay: 0.2s;">
                    <div class="bg-[#F3F4F6] rounded-2xl p-6 text-center card-hover border border-gray-100">
                        <div class="w-14 h-14 mx-auto bg-[#14B8A6]/10 rounded-2xl flex items-center justify-center mb-3">
                            <i class="fa-solid fa-book text-[#14B8A6] text-xl"></i>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalBuku ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Koleksi Buku</p>
                    </div>
                    <div class="bg-[#F3F4F6] rounded-2xl p-6 text-center card-hover border border-gray-100">
                        <div class="w-14 h-14 mx-auto bg-blue-50 rounded-2xl flex items-center justify-center mb-3">
                            <i class="fa-solid fa-users text-blue-500 text-xl"></i>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalUser ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Anggota Aktif</p>
                    </div>
                    <div class="bg-[#F3F4F6] rounded-2xl p-6 text-center card-hover border border-gray-100">
                        <div class="w-14 h-14 mx-auto bg-violet-50 rounded-2xl flex items-center justify-center mb-3">
                            <i class="fa-solid fa-handshake text-violet-500 text-xl"></i>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalPeminjaman ?? 0 }}</p>
                        <p class="text-xs text-gray-400 mt-1">Peminjaman</p>
                    </div>
                    <div class="bg-[#F3F4F6] rounded-2xl p-6 text-center card-hover border border-gray-100">
                        <div class="w-14 h-14 mx-auto bg-amber-50 rounded-2xl flex items-center justify-center mb-3">
                            <i class="fa-solid fa-star text-amber-400 text-xl"></i>
                        </div>
                        <p class="text-3xl font-bold text-gray-800">{{ $avgRating ?? '0' }}</p>
                        <p class="text-xs text-gray-400 mt-1">Rating</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-[#F3F4F6] border-t border-gray-100 px-8 py-8 mt-16">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="w-8 h-8 bg-[#14B8A6] rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-book-open text-white text-xs"></i>
                </div>
                <span class="font-bold text-gray-700">Perpustakaan Digital</span>
            </div>
            <p class="text-xs text-gray-400">&copy; {{ date('Y') }} Perpustakaan Digital. Powered By Muhammad Syahrul Firmansyah</p>
        </div>
    </footer>

</body>

</html>
