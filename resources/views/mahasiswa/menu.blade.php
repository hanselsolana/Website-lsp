<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Menu Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 2rem;
            font-weight: bold;
            text-decoration: none;
            color: #333;
        }

        .back-button:hover {
            color: #000;
        }
    </style>
</head>
<body class="p-5">
    <a href="{{ url('/') }}" class="back-button" title="Kembali ke Beranda">
        &#8592;
    </a>

    <div class="container text-center mt-5">
        <h1 class="mb-4">Menu Mahasiswa</h1>

        @if (session('success'))
            <div class="alert alert-success w-50 mx-auto">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-grid gap-3 col-6 mx-auto">
            <a href="{{ route('mahasiswa.form') }}" class="btn btn-primary btn-lg">Form Peminjaman Buku</a>
            <a href="{{ route('mahasiswa.form.pengembalian') }}" class="btn btn-success btn-lg">Form Pengembalian Buku</a>
        </div>
    </div>
</body>
</html>
