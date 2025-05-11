<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Peminjaman Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container">
        <h1 class="mb-4 text-center">Form Peminjaman Buku</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('mahasiswa.submit') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Mahasiswa</label>
                <input type="text" class="form-control" id="nama" name="nama" required value="{{ old('nama') }}">
            </div>

            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required value="{{ old('tanggal_pinjam', date('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label for="buku_id" class="form-label">Pilih Buku</label>
                <select class="form-select" id="buku_id" name="buku_id" required>
                    <option value="">-- Pilih Buku --</option>
                    @foreach ($buku as $item)
                        <option value="{{ $item->id }}">{{ $item->judul }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Pengembalian Buku</label>
                <input type="text" class="form-control" id="tanggal_pengembalian" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        const tanggalPinjam = document.getElementById('tanggal_pinjam');
        const tanggalPengembalian = document.getElementById('tanggal_pengembalian');

        // Fungsi untuk memperbarui tanggal pengembalian secara otomatis
        function updateTanggalPengembalian() {
            // Mengambil tanggal pinjam dari input
            const tgl = new Date(tanggalPinjam.value);
            
            // Menambah 7 hari ke tanggal pinjam
            tgl.setDate(tgl.getDate() + 7);
            
            // Format tanggal pengembalian dalam format YYYY-MM-DD
            const tglPengembalian = tgl.toISOString().split('T')[0];
            
            // Mengupdate nilai di input tanggal_pengembalian
            tanggalPengembalian.value = tglPengembalian;
        }

        // Menjalankan fungsi updateTanggalPengembalian saat tanggal pinjam berubah
        tanggalPinjam.addEventListener('change', updateTanggalPengembalian);

        // Menjalankan fungsi saat halaman pertama kali dimuat
        window.addEventListener('load', updateTanggalPengembalian);
    </script>
</body>
</html>
