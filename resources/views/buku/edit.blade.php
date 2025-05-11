@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <h1 class="mb-4">Edit Buku</h1>

    <form action="{{ route('buku.update', $buku->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ $buku->judul }}" required>
        </div>
        <div class="mb-3">
            <label>Penulis</label>
            <input type="text" name="penulis" class="form-control" value="{{ $buku->penulis }}" required>
        </div>
        <div class="mb-3">
            <label>Penerbit</label>
            <input type="text" name="penerbit" class="form-control" value="{{ $buku->penerbit }}">
        </div>
        <div class="mb-3">
            <label>Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control" value="{{ $buku->tahun_terbit }}">
        </div>
        <div class="mb-3">
            <label>Sinopsis</label>
            <textarea name="sinopsis" class="form-control">{{ $buku->sinopsis }}</textarea>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
    </form>
@endsection