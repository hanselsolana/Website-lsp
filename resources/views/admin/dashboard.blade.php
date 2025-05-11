@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Dashboard Admin</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <a href="{{ route('admin.buku.index') }}" class="btn btn-primary btn-lg w-100">
                <i class="bi bi-book"></i> Daftar Buku
            </a>
        </div>
        <div class="col-md-6 mb-3">
            <a href="{{ route('admin.daftar.peminjam') }}" class="btn btn-warning btn-lg w-100">
                <i class="bi bi-archive"></i> Daftar Peminjam
            </a>
        </div>
    </div>
</div>
@endsection


