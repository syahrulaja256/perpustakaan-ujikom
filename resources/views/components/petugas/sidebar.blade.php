<div class="w-[270px] min-h-screen bg-[#14B8A6] text-white flex flex-col shadow-2xl relative overflow-hidden">

    {{-- Decorative circles --}}
    <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full"></div>
    <div class="absolute bottom-20 -left-8 w-32 h-32 bg-white/5 rounded-full"></div>

    {{-- Logo --}}
    <div class="relative z-10 px-6 py-7 border-b border-white/20">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center shadow-lg shadow-black/10">
                <i class="fa-solid fa-user-tie text-[#14B8A6] text-lg"></i>
            </div>
            <div>
                <h1 class="text-base font-bold tracking-wide">PETUGAS</h1>
                <p class="text-[10px] text-white/70 font-medium tracking-widest">PERPUSTAKAAN</p>
            </div>
        </div>
    </div>

    {{-- Menu --}}
    <nav class="relative z-10 flex-1 px-4 py-6 space-y-1.5">
        <p class="px-4 text-[10px] font-bold text-white/50 uppercase tracking-widest mb-3">Menu Utama</p>

        <a href="{{ route('petugas.dashboard') }}"
            class="sidebar-link {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-gauge-high text-white text-xs"></i>
            </div>
            Dashboard
        </a>

        <a href="{{ route('petugas.buku') }}"
            class="sidebar-link {{ request()->routeIs('petugas.buku') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-book text-white text-xs"></i>
            </div>
            Data Buku
        </a>

        <a href="{{ route('petugas.kategori') }}"
            class="sidebar-link {{ request()->routeIs('petugas.kategori') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-tags text-white text-xs"></i>
            </div>
            Data Kategori
        </a>

                <a href="{{ route('petugas.ulasan') }}"
            class="sidebar-link {{ request()->routeIs('petugas.ulasan') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-star text-white text-xs"></i>
            </div>
            Ulasan
        </a>


        <p class="px-4 text-[10px] font-bold text-white/50 uppercase tracking-widest mb-3 mt-5">Transaksi</p>

        <a href="{{ route('petugas.peminjaman') }}"
            class="sidebar-link {{ request()->routeIs('petugas.peminjaman') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-book-open text-white text-xs"></i>
            </div>
            Peminjaman
        </a>



        <p class="px-4 text-[10px] font-bold text-white/50 uppercase tracking-widest mb-3 mt-5">Laporan</p>

        <a href="{{ route('petugas.laporan') }}"
            class="sidebar-link {{ request()->routeIs('petugas.laporan') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-chart-pie text-white text-xs"></i>
            </div>
            Laporan Peminjaman
        </a>

        <a href="{{ route('petugas.laporan.buku') }}"
            class="sidebar-link {{ request()->routeIs('petugas.laporan.buku') ? 'active' : '' }} flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-white/90 hover:text-white hover:bg-white/15 transition-all duration-200">
            <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                <i class="fa-solid fa-book-bookmark text-white text-xs"></i>
            </div>
            Laporan Buku
        </a>
    </nav>

    {{-- Profile & Logout --}}
    <div class="relative z-10 px-4 pb-6 space-y-3">
        <a href="{{ route('profile') }}" class="bg-white/15 backdrop-blur-sm rounded-xl p-4 flex items-center gap-3 hover:bg-white/25 transition-all duration-200 cursor-pointer group block border border-white/10">
            <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-sm font-bold text-[#14B8A6] shadow-lg">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate group-hover:text-white transition">{{ Auth::user()->name }}</p>
                <p class="text-[10px] text-white/70 flex items-center gap-1">
                    <i class="fa-solid fa-circle text-white text-[6px]"></i>
                    Petugas
                </p>
            </div>
            <i class="fa-solid fa-chevron-right text-white/50 text-xs group-hover:text-white transition"></i>
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center justify-center gap-2 bg-white/15 hover:bg-red-500 text-white py-3 rounded-xl transition-all duration-300 text-sm font-semibold border border-white/10 hover:border-red-500">
                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                Logout
            </button>
        </form>
    </div>

</div>
