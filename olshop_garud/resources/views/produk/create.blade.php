@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Produk</h2>

    <form action="{{ route('produk.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="kode_produk">Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="text" name="harga" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary my-3">Simpan</button>
    </form>
    <a href="{{ route('adminHome') }}" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>
</div>
@endsection
