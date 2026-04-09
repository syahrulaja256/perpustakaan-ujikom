@extends('layouts.admin')

@section('page-title', 'Detail Ulasan')
@section('page-subtitle', 'Lihat ulasan lengkap dari pengguna')

@section('content')
            <div class="max-w-4xl">

                <!-- Detail Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-8 space-y-6">
                        <!-- User Info -->
                        <div class="pb-6 border-b border-gray-200">
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ strtoupper(substr($ulasan->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $ulasan->user->name ?? '-' }}</h3>
                                    <p class="text-gray-600">{{ $ulasan->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Book Info -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-3">Buku</h3>
                            <div class="p-4 bg-blue-50 rounded-lg">
                                <p class="text-lg font-semibold text-gray-800">{{ $ulasan->buku->judul ?? '-' }}</p>
                                <p class="text-sm text-gray-600 mt-1">Penulis: {{ $ulasan->buku->penulis ?? '-' }}</p>
                                <p class="text-sm text-gray-600">Penerbit: {{ $ulasan->buku->penerbit ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-3">Rating</h3>
                            <div class="flex items-center gap-2 mb-2">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < ($ulasan->rating ?? 0))
                                        <i class="fa-solid fa-star text-yellow-400 text-2xl"></i>
                                    @else
                                        <i class="fa-regular fa-star text-gray-300 text-2xl"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-2xl font-bold text-gray-800">{{ $ulasan->rating ?? 0 }}<span class="text-lg font-normal text-gray-600">/5</span></p>
                        </div>

                        <!-- Review Text -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-3">Ulasan</h3>
                            <div class="p-4 bg-gray-50 rounded-lg">
                                <p class="text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $ulasan->ulasan }}</p>
                            </div>
                        </div>

                        <!-- Dates -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-2">Tanggal Peminjaman</h3>
                                <p class="text-gray-800 font-medium">{{ $ulasan->tanggal_pinjam ? $ulasan->tanggal_pinjam->format('d/m/Y') : '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-2">Tanggal Pengembalian</h3>
                                <p class="text-gray-800 font-medium">{{ $ulasan->tanggal_kembali ? $ulasan->tanggal_kembali->format('d/m/Y') : '-' }}</p>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-2">Status</h3>
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-medium
                                    @if ($ulasan->status === 'Dikembalikan')
                                        bg-green-100 text-green-700
                                    @elseif ($ulasan->status === 'Dikonfirmasi')
                                        bg-blue-100 text-blue-700
                                    @elseif ($ulasan->status === 'Menunggu')
                                        bg-yellow-100 text-yellow-700
                                    @else
                                        bg-red-100 text-red-700
                                    @endif
                                ">
                                    {{ $ulasan->status ?? '-' }}
                                </span>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-2">Tanggal Ulasan</h3>
                                <p class="text-gray-800 font-medium">{{ $ulasan->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-200 flex gap-3 justify-end">
                        <a href="{{ route('admin.ulasan.index') }}"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors duration-200 font-medium">
                            <i class="fa-solid fa-x"></i>
                            Tutup
                        </a>
                        <form action="{{ route('admin.ulasan.destroy', $ulasan->id) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 font-medium">
                                <i class="fa-solid fa-trash"></i>
                                Hapus Ulasan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
@endsection
