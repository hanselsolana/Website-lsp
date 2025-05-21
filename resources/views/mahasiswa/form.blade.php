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
                <input type="date" class="form-control" id="tanggal_pinjam" name="tanggal_pinjam" required
                    value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}">
            </div>

            <div class="mb-3">
                <label for="buku_id" class="form-label">Pilih Buku</label>
                <select name="buku_id" id="buku_id" class="form-control" required {{ count($bukuTersedia) == 0 ? 'disabled' : '' }}>
                    <option value="">-- Pilih Buku --</option>
                    @forelse ($bukuTersedia as $buku)
                        <option value="{{ $buku->id }}">{{ $buku->judul }}</option>
                    @empty
                        <option disabled>Tidak ada buku tersedia untuk dipinjam</option>
                    @endforelse
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal_pengembalian" class="form-label">Tanggal Pengembalian</label>
                <input type="date" class="form-control" id="tanggal_pengembalian" name="tanggal_pengembalian" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        const tanggalPinjam = document.getElementById('tanggal_pinjam');
        const tanggalPengembalian = document.getElementById('tanggal_pengembalian');

        function updateTanggalPengembalian() {
            const tgl = new Date(tanggalPinjam.value);
            if (!isNaN(tgl)) {
                tgl.setDate(tgl.getDate() + 7);
                const tglPengembalian = tgl.toISOString().split('T')[0];
                tanggalPengembalian.value = tglPengembalian;
            } else {
                tanggalPengembalian.value = '';
            }
        }

        tanggalPinjam.addEventListener('change', updateTanggalPengembalian);
        window.addEventListener('load', updateTanggalPengembalian);
    </script>
</body>

</html>
