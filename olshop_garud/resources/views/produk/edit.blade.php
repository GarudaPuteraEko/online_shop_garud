@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Produk</h2>

    <form id="edit-produk-form" action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="kode_produk">Kode Produk</label>
            <input type="text" name="kode_produk" class="form-control" value="{{ old('kode_produk', $produk->kode_produk) }}" required>
        </div>

        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $produk->nama) }}" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="text" name="harga" class="form-control" value="{{ old('harga', $produk->harga) }}" required>
        </div>

        <div class="form-group">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" 
                            {{ $produk->kategori_id == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="gambar">Ganti Gambar Produk (Opsional)</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        @if($produk->gambar)
            <div class="form-group">
                <label>Gambar Saat Ini:</label><br>
                <img src="{{ asset('storage/gambar/' . $produk->gambar) }}" alt="Gambar Produk" style="max-width: 200px;" class="mb-3">
            </div>
        @endif

        <button type="submit" class="btn btn-primary my-3">Simpan</button>
    </form>

    <a href="{{ route('adminHome') }}" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const form = document.getElementById('edit-produk-form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Simpan Perubahan?',
            text: 'Perubahan produk akan disimpan.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Simpan',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
</script>
@endsection
