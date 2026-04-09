@extends('layouts.petugas')

@section('page-title', 'Ulasan Pengguna')
@section('page-subtitle', 'Lihat semua ulasan yang dikirim oleh user')

@section('content')
    <div class="px-8 py-8">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Daftar Ulasan</h1>
                        <p class="text-sm text-gray-500">Tampilkan ulasan pengguna yang sudah diisi pada peminjaman.</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    @if ($ulasans->count() > 0)
                        <table class="min-w-full text-left">
                            <thead class="bg-[#14B8A6] text-white">
                                <tr>
                                    <th class="px-6 py-4 text-sm font-semibold">No</th>
                                    <th class="px-6 py-4 text-sm font-semibold">User</th>
                                    <th class="px-6 py-4 text-sm font-semibold">Buku</th>
                                    <th class="px-6 py-4 text-sm font-semibold">Rating</th>
                                    <th class="px-6 py-4 text-sm font-semibold">Ulasan</th>
                                    <th class="px-6 py-4 text-sm font-semibold">Status</th>
                                    <th class="px-6 py-4 text-sm font-semibold">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($ulasans as $index => $ulasan)
                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $ulasan->user->name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">{{ $ulasan->buku->judul ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <div class="flex items-center gap-1">
                                                @for ($i = 0; $i < 5; $i++)
                                                    @if ($i < ($ulasan->rating ?? 0))
                                                        <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                                    @else
                                                        <i class="fa-regular fa-star text-gray-300 text-xs"></i>
                                                    @endif
                                                @endfor
                                                <span class="ml-2">{{ $ulasan->rating ?? 0 }}/5</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700 max-w-xl">
                                            {{ \Illuminate\Support\Str::limit($ulasan->ulasan, 80) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $ulasan->status === 'Dikembalikan' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700' }}">
                                                {{ $ulasan->status ?? 'Unknown' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $ulasan->updated_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-12 text-center text-gray-500">
                            <i class="fa-solid fa-inbox text-5xl mb-4 opacity-20"></i>
                            <p class="text-lg font-medium">Belum ada ulasan</p>
                            <p class="text-sm">Ulasan dari user akan muncul setelah peminjaman selesai dan dikembalikan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
