@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <h1 class="mb-4">Edit Buku</h1>

    {{-- Tampilkan error validasi jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form edit buku --}}
    <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="judul" class="form-label">Judul</label>
            <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $buku->judul) }}" required>
        </div>

        <div class="mb-3">
            <label for="penulis" class="form-label">Penulis</label>
            <input type="text" name="penulis" id="penulis" class="form-control" value="{{ old('penulis', $buku->penulis) }}" required>
        </div>

        <div class="mb-3">
            <label for="penerbit" class="form-label">Penerbit</label>
            <input type="text" name="penerbit" id="penerbit" class="form-control" value="{{ old('penerbit', $buku->penerbit) }}">
        </div>

        <div class="mb-3">
            <label for="tahun_terbit" class="form-label">Tahun Terbit</label>
            <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
        </div>

        <div class="mb-3">
            <label for="sinopsis" class="form-label">Sinopsis</label>
            <textarea name="sinopsis" id="sinopsis" class="form-control" rows="4">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Buku Saat Ini</label><br>
            @if ($buku->gambar)
                <img src="{{ asset($buku->gambar) }}" width="120" class="mb-2 rounded shadow"><br>

                {{-- Form hapus gambar --}}
                <form action="{{ route('buku.hapusGambar', $buku->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus gambar ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm mb-3">Hapus Gambar</button>
                </form>
            @else
                <p class="text-muted">Tidak ada gambar.</p>
            @endif
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Ganti Gambar (Opsional)</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection
