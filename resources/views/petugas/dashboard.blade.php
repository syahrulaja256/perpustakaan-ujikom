@extends('layouts.petugas')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan data perpustakaan')

@section('content')
    <div class="animate-fade-in-up">

        {{-- Welcome Banner --}}
        <div class="bg-[#14B8A6] rounded-2xl p-6 mb-8 relative overflow-hidden">
            <div class="absolute -top-6 -right-6 w-32 h-32 bg-white/10 rounded-full"></div>
            <div class="absolute bottom-0 right-20 w-20 h-20 bg-white/5 rounded-full"></div>
            <div class="relative z-10">
                <h3 class="text-xl font-bold text-white mb-1">Selamat Datang, {{ Auth::user()->name }}! 👋</h3>
                <p class="text-white/80 text-sm">Berikut ringkasan data perpustakaan hari ini.</p>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-3 gap-5 mb-8">

            <div class="stat-card bg-[#F3F4F6] rounded-2xl p-6 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-[#14B8A6] rounded-xl flex items-center justify-center shadow-lg shadow-teal-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-book text-white text-lg"></i>
                    </div>
                    <span class="text-[10px] font-bold text-[#14B8A6] bg-teal-50 px-3 py-1.5 rounded-lg uppercase tracking-wider">Koleksi</span>
                </div>
                <p class="text-3xl font-bold text-gray-800 mb-1 animate-count-up">{{ $totalBuku }}</p>
                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                    <i class="fa-solid fa-book-open text-[#14B8A6] text-[10px]"></i>
                    Total Buku
                </p>
            </div>

            <div class="stat-card bg-[#F3F4F6] rounded-2xl p-6 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-book-open text-white text-lg"></i>
                    </div>
                    <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-3 py-1.5 rounded-lg uppercase tracking-wider">Aktif</span>
                </div>
                <p class="text-3xl font-bold text-gray-800 mb-1 animate-count-up">{{ $totalPinjam }}</p>
                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                    <i class="fa-solid fa-arrow-right-arrow-left text-blue-500 text-[10px]"></i>
                    Sedang Dipinjam
                </p>
            </div>

            <div class="stat-card bg-[#F3F4F6] rounded-2xl p-6 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
                        <i class="fa-solid fa-circle-check text-white text-lg"></i>
                    </div>
                    <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-3 py-1.5 rounded-lg uppercase tracking-wider">Selesai</span>
                </div>
                <p class="text-3xl font-bold text-gray-800 mb-1 animate-count-up">{{ $totalKembali }}</p>
                <p class="text-xs text-gray-500 flex items-center gap-1.5">
                    <i class="fa-solid fa-check-double text-emerald-500 text-[10px]"></i>
                    Dikembalikan
                </p>
            </div>

        </div>

        {{-- Quick Actions --}}
        <div class="bg-[#F3F4F6] rounded-2xl p-6">
            <h3 class="text-sm font-bold text-gray-700 mb-5 flex items-center gap-2">
                <div class="w-8 h-8 bg-[#14B8A6] rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-bolt text-white text-xs"></i>
                </div>
                Aksi Cepat
            </h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                <a href="{{ route('petugas.peminjaman') }}"
                    class="flex items-center gap-3 p-4 bg-white rounded-xl hover:shadow-md hover:-translate-y-0.5 border border-gray-100 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center group-hover:bg-[#14B8A6] transition-colors duration-300">
                        <i class="fa-solid fa-book-open text-[#14B8A6] text-sm group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Kelola</p>
                        <p class="text-[10px] text-gray-400">Peminjaman</p>
                    </div>
                </a>
                <a href="{{ route('petugas.buku') }}?tambah=1"
                    class="flex items-center gap-3 p-4 bg-white rounded-xl hover:shadow-md hover:-translate-y-0.5 border border-gray-100 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center group-hover:bg-[#14B8A6] transition-colors duration-300">
                        <i class="fa-solid fa-plus text-[#14B8A6] text-sm group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Tambah</p>
                        <p class="text-[10px] text-gray-400">Buku Baru</p>
                    </div>
                </a>
                <a href="{{ route('petugas.kategori') }}"
                    class="flex items-center gap-3 p-4 bg-white rounded-xl hover:shadow-md hover:-translate-y-0.5 border border-gray-100 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center group-hover:bg-[#14B8A6] transition-colors duration-300">
                        <i class="fa-solid fa-tags text-[#14B8A6] text-sm group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Kelola</p>
                        <p class="text-[10px] text-gray-400">Kategori</p>
                    </div>
                </a>
                <a href="{{ route('petugas.laporan') }}"
                    class="flex items-center gap-3 p-4 bg-white rounded-xl hover:shadow-md hover:-translate-y-0.5 border border-gray-100 transition-all duration-300 group">
                    <div class="w-10 h-10 bg-teal-50 rounded-lg flex items-center justify-center group-hover:bg-[#14B8A6] transition-colors duration-300">
                        <i class="fa-solid fa-chart-pie text-[#14B8A6] text-sm group-hover:text-white transition-colors duration-300"></i>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-700">Laporan</p>
                        <p class="text-[10px] text-gray-400">Peminjaman</p>
                    </div>
                </a>
            </div>
        </div>

    </div>
@endsection
