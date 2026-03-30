{{-- @extends('layouts.user')

@section('content')
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4">Riwayat Peminjaman</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border-collapse border border-gray-200">
                <thead class="bg-teal-500 text-white">
                    <tr>
                        <th class="border px-4 py-2">No</th>
                        <th class="border px-4 py-2">Buku</th>
                        <th class="border px-4 py-2">Tanggal Pinjam</th>
                        <th class="border px-4 py-2">Tanggal Kembali</th>
                        <th class="border px-4 py-2">Status</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pinjaman as $index => $p)
                        <tr class="text-center">
                            <td class="border px-4 py-2">{{ $index + 1 }}</td>
                            <td class="border px-4 py-2">Buku {{ $p['buku_id'] }}</td>
                            <td class="border px-4 py-2">{{ $p['tanggal_pinjam'] }}</td>
                            <td class="border px-4 py-2">{{ $p['tanggal_kembali'] }}</td>
                            <td class="border px-4 py-2">{{ $p['status'] }}</td>
                            <td class="border px-4 py-2">
                                @if ($p['status'] == 'Dikonfirmasi')
                                    <form method="POST" action="{{ route('user.kembalikan', $index) }}">
                                        @csrf
                                        <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">
                                            Kembalikan
                                        </button>
                                    </form>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Belum ada peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection --}}
