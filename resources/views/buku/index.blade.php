<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h1 class="mb-4">Daftar Buku</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">+ Tambah Buku</a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Tahun Terbit</th>
                    <th>Sinopsis</th>
                    <th>Status Peminjaman</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($buku as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->penulis }}</td>
                        <td>{{ $item->penerbit ?? '-' }}</td>
                        <td>{{ $item->tahun_terbit ?? '-' }}</td>
                        <td>{{ $item->sinopsis ?? '-' }}</td>
                        <td>
                            @if ($item->status_peminjaman === 'dipinjam')
                                <span class="badge bg-danger">Dipinjam</span>
                            @else
                                <span class="badge bg-success">Tersedia</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('buku.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('buku.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Belum ada data buku.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>
