@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Produk</h2>

    <form action="{{ route('produk.update', $produk->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kode_produk">Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control" value="{{ $produk->kode_produk }}" required>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ $produk->nama }}" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="text" name="harga" class="form-control" value="{{ $produk->harga }}" required>
        </div>

        <button type="submit" class="btn btn-primary my-3">Simpan Perubahan</button>
    </form>
</div>
@endsection
