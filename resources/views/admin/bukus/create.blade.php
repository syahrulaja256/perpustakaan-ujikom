@extends('layouts.admin')

@section('content')
    <h2 class="text-2xl font-bold mb-4">Tambah Buku Baru</h2>

    <form method="POST" action="{{ route('admin.bukus.store') }}" enctype="multipart/form-data"
        class="bg-white p-6 rounded shadow space-y-6 max-w-4xl mx-auto">
        @csrf

        {{-- Judul, Penulis, Penerbit --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" name="judul" placeholder="Judul Buku" required class="w-full border rounded px-3 py-2">
            <input type="text" name="penulis" placeholder="Penulis" required class="w-full border rounded px-3 py-2">
            <input type="text" name="penerbit" placeholder="Penerbit" required class="w-full border rounded px-3 py-2">
        </div>

        {{-- Tahun Terbit + Kategori --}}
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

        {{-- Upload Cover --}}
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
            <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                Simpan Buku
            </button>
        </div>
    </form>

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
