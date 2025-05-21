@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Buku</h1>
        <a href="{{ route('buku.create') }}" class="btn btn-primary">Tambah Buku</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Tahun Terbit</th>
                <th>Sinopsis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($buku as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if ($item->gambar)
                            <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}" width="80">
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td>{{ $item->judul }}</td>
                    <td>{{ $item->penulis }}</td>
                    <td>{{ $item->penerbit ?? '-' }}</td>
                    <td>{{ $item->tahun_terbit ?? '-' }}</td>
                    <td>{{ $item->sinopsis ?? '-' }}</td>
                    <td>
                        <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('buku.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data buku</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
