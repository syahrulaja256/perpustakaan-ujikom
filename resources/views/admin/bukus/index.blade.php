@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Kelola Buku</h2>

    {{-- Form Tambah Buku --}}
    <div class="bg-white p-6 rounded shadow mb-6 max-w-4xl mx-auto">
        <h3 class="text-lg font-semibold mb-4">Tambah Buku Baru</h3>
        <form method="POST" action="{{ route('admin.bukus.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="judul" placeholder="Judul Buku" required
                    class="w-full border rounded px-3 py-2">
                <input type="text" name="penulis" placeholder="Penulis" required class="w-full border rounded px-3 py-2">
                <input type="text" name="penerbit" placeholder="Penerbit" required
                    class="w-full border rounded px-3 py-2">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="number" name="tahun_terbit" placeholder="Tahun Terbit" required
                    class="w-full border rounded px-3 py-2">
                <select name="kategori_id" required class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col md:flex-row gap-4 items-start">
                <div class="flex-1">
                    <input type="file" name="cover" accept="image/*" id="coverInput"
                        class="border rounded px-3 py-2 w-full">
                </div>
                <div class="flex-1">
                    <img id="coverPreview" class="w-32 h-40 object-cover border rounded hidden" alt="Preview Cover">
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Simpan
                    Buku</button>
            </div>
        </form>
    </div>

    {{-- Daftar Buku --}}
    <table class="min-w-full border border-gray-200">
        <thead class="bg-teal-500 text-white">
            <tr>
                <th class="border px-3 py-2">No</th>
                <th class="border px-3 py-2">Judul</th>
                <th class="border px-3 py-2">Penulis</th>
                <th class="border px-3 py-2">Penerbit</th>
                <th class="border px-3 py-2">Tahun Terbit</th>
                <th class="border px-3 py-2">Kategori</th>
                <th class="border px-3 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bukus as $i => $b)
                <tr class="text-center">
                    <td class="border px-2 py-1">{{ $i + 1 }}</td>
                    <td class="border px-2 py-1">{{ $b->judul }}</td>
                    <td class="border px-2 py-1">{{ $b->penulis }}</td>
                    <td class="border px-2 py-1">{{ $b->penerbit }}</td>
                    <td class="border px-2 py-1">{{ $b->tahun_terbit }}</td>
                    <td class="border px-2 py-1">{{ $b->kategori ? $b->kategori->nama : '-' }}</td>
                    <td class="border px-2 py-1 space-x-2">
                        <button class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600">Edit</button>
                        <button class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Hapus</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-2">Belum ada buku</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Preview Cover --}}
    <script>
        const coverInput = document.getElementById('coverInput');
        const coverPreview = document.getElementById('coverPreview');

        coverInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    coverPreview.src = e.target.result;
                    coverPreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                coverPreview.classList.add('hidden');
            }
        });
    </script>
@endsection
