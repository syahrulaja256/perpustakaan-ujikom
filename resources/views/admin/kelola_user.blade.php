@extends('layouts.admin')

@section('page-title', 'Kelola User')
@section('page-subtitle', 'Daftar pengguna terdaftar')

@section('content')
    <div class="animate-fade-in-up">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full table-modern">
                    <thead>
                        <tr class="bg-gradient-to-r from-slate-800 to-slate-700 text-white">
                            <th class="px-5 py-4 text-left text-xs font-semibold">No</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Nama</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold">Email</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold">Role</th>
                            <th class="px-5 py-4 text-center text-xs font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $i => $u)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $i + 1 }}</td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-400 to-teal-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-slate-700">{{ $u->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5 text-sm text-slate-500">{{ $u->email }}</td>
                                <td class="px-5 py-3.5 text-center">
                                    <span class="inline-flex items-center bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-xs font-semibold">
                                        {{ ucfirst($u->role) }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-center">
                                    <form action="{{ route('admin.user.hapus', $u->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="inline-flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold transition shadow-sm">
                                            <i class="fa-solid fa-trash text-[10px]"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-slate-400 text-sm">Belum ada user</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
