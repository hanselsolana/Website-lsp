@extends('layouts.app') <!-- Ganti sesuai layout Anda -->

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Daftar Peminjam - Menunggu Validasi Pengembalian</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.validasi.pengembalian') }}">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Pengembalian Buku</th>
                        <th class="text-center">Valid</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalians as $item)
                        <tr>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->buku->judul ?? '-' }}</td>
                            <td>
                                {{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y') : '-' }}
                            </td>
                            <td>
                                {{ $item->dikembalikan_pada ? \Carbon\Carbon::parse($item->dikembalikan_pada)->format('d-m-Y') : '-' }}
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="validasi_ids[]" value="{{ $item->id }}">
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada pengembalian yang menunggu validasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengembalians->count() > 0)
            <div class="text-end mt-3">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        @endif
    </form>
</div>
@endsection
