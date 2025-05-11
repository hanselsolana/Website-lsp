<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Pengembalian Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .back-arrow {
            font-size: 2rem;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body class="p-5">
    <div class="container">
        <a href="{{ url('/mahasiswa') }}" class="back-arrow position-absolute top-0 start-0 p-4">&larr;</a>
        <h1 class="text-center mb-4">Form Pengembalian Buku</h1>

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('mahasiswa.pengembalian.submit') }}" id="formPengembalian">
            @csrf
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="nama" name="nama" required onblur="fetchData()">
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Buku</label>
                <input type="text" id="judul_buku" class="form-control" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pengembalian</label>
                <input type="text" id="tanggal_pengembalian" class="form-control" readonly>
            </div>

            <!-- Tombol trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#konfirmasiModal">
                Submit Pengembalian
            </button>
        </form>
    </div>

    <!-- Modal Konfirmasi -->
    <div class="modal fade" id="konfirmasiModal" tabindex="-1" aria-labelledby="konfirmasiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="konfirmasiModalLabel">Konfirmasi Pengembalian</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Data Peminjam Buku Sudah Sesuai?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                    <button type="button" class="btn btn-primary" onclick="submitForm()">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        async function fetchData() {
            const nama = document.getElementById('nama').value;
            if (!nama) return;

            try {
                const response = await fetch(`/api/pengembalian/data?nama=${encodeURIComponent(nama)}`);
                const data = await response.json();

                document.getElementById('judul_buku').value = data.judul || '';
                document.getElementById('tanggal_pengembalian').value = data.tanggal_kembali || '';
            } catch (error) {
                console.error('Gagal mengambil data:', error);
            }
        }

        function submitForm() {
            document.getElementById('formPengembalian').submit();
        }
    </script>
</body>

</html>
