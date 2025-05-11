<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container text-center">
        <h1 class="mb-4">Selamat Datang di Perpustakaan</h1>

        <div class="d-grid gap-3 col-6 mx-auto">
            <a href="{{ route('admin.login') }}" class="btn btn-warning btn-lg">Masuk Sebagai Admin</a>
            <a href="{{ route('mahasiswa.menu') }}" class="btn btn-primary btn-lg">Masuk Sebagai Mahasiswa</a>
        </div>
    </div>
</body>
</html>
