@extends('layouts.admin')

@section('page-title', 'Kelola Ulasan')
@section('page-subtitle', 'Kelola dan lihat semua ulasan dari pengguna')

@section('content')
            <div class="max-w-7xl">

                <!-- Alert Messages -->
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg text-green-700 flex items-center gap-2">
                        <i class="fa-solid fa-check-circle"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg text-red-700 flex items-center gap-2">
                        <i class="fa-solid fa-exclamation-circle"></i>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Table Card -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        @if ($ulasans->count() > 0)
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-teal-500 to-cyan-500 text-white">
                                        <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">User</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">Buku</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">Rating</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">Ulasan</th>
                                        <th class="px-6 py-4 text-left text-sm font-semibold">Tanggal</th>
                                        <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach ($ulasans as $index => $ulasan)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4 text-sm text-gray-700 font-medium">
                                                {{ ($ulasans->currentPage() - 1) * $ulasans->perPage() + $index + 1 }}
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <div class="flex items-center gap-2">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-teal-400 to-cyan-500 flex items-center justify-center text-white text-xs font-bold">
                                                        {{ strtoupper(substr($ulasan->user->name ?? 'U', 0, 1)) }}
                                                    </div>
                                                    <span class="text-gray-700 font-medium">{{ $ulasan->user->name ?? '-' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                <span class="inline-block px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-medium">
                                                    {{ $ulasan->buku->judul ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm">
                                                <div class="flex items-center gap-1">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i < ($ulasan->rating ?? 0))
                                                            <i class="fa-solid fa-star text-yellow-400"></i>
                                                        @else
                                                            <i class="fa-regular fa-star text-gray-300"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="ml-2 text-gray-600 font-medium">{{ $ulasan->rating ?? 0 }}/5</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-700">
                                                <div class="max-w-xs truncate" title="{{ $ulasan->ulasan }}">
                                                    {{ Str::limit($ulasan->ulasan, 50) }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $ulasan->updated_at->format('d/m/Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.ulasan.show', $ulasan->id) }}"
                                                        class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors duration-200 text-sm font-medium"
                                                        title="Lihat Detail">
                                                        <i class="fa-solid fa-eye text-xs"></i>
                                                        Lihat
                                                    </a>
                                                    <form action="{{ route('admin.ulasan.destroy', $ulasan->id) }}"
                                                        method="POST"
                                                        class="inline"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus ulasan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors duration-200 text-sm font-medium"
                                                            title="Hapus">
                                                            <i class="fa-solid fa-trash text-xs"></i>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    Menampilkan hasil <span class="font-semibold">{{ $ulasans->firstItem() }}</span>
                                    hingga <span class="font-semibold">{{ $ulasans->lastItem() }}</span>
                                    dari <span class="font-semibold">{{ $ulasans->total() }}</span> ulasan
                                </div>
                                <div>
                                    {{ $ulasans->links('pagination::tailwind') }}
                                </div>
                            </div>
                        @else
                            <div class="p-12 text-center text-gray-500">
                                <i class="fa-solid fa-inbox text-5xl mb-4 opacity-20"></i>
                                <p class="text-lg font-medium">Belum ada ulasan</p>
                                <p class="text-sm">Ulasan dari pengguna akan ditampilkan di sini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
@endsection
