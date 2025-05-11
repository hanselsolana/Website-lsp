@php
    $b = isset($buku) ? $buku : null;
@endphp

<div class="mb-3">
    <label>Judul</label>
    <input type="text" name="judul" value="{{ old('judul', $b->judul ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label>Penulis</label>
    <input type="text" name="penulis" value="{{ old('penulis', $b->penulis ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label>Penerbit</label>
    <input type="text" name="penerbit" value="{{ old('penerbit', $b->penerbit ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Tahun Terbit</label>
    <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit', $b->tahun_terbit ?? '') }}" class="form-control">
</div>

<div class="mb-3">
    <label>Sinopsis</label>
    <textarea name="sinopsis" class="form-control">{{ old('sinopsis', $b->sinopsis ?? '') }}</textarea>
</div>
