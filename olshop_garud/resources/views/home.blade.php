@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card border-0 shadow rounded-4">
                <div class="card-header bg-dark text-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">Produk Tersedia</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('cart.show') }}" class="btn btn-sm btn-outline-warning">Keranjang</a>
                        <a href="{{ route('transaction.approval') }}" class="btn btn-sm btn-outline-success">Approval</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="GET" action="{{ route('home') }}" class="row g-3 align-items-end mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Filter Kategori</label>
                            <select name="kategori" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Cari Produk</label>
                            <input type="text" name="search" class="form-control" placeholder="Cari nama produk..." value="{{ request('search') }}">
                        </div>

                        <div class="col-auto">
                            <button class="btn btn-outline-primary" type="submit">Terapkan</button>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Kode</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Kategori</th>
                                    <th scope="col">Gambar</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produks as $produk)
                                <tr>
                                    <td>{{ $produk->kode_produk }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td>Rp{{ number_format($produk->harga) }}</td>
                                    <td>{{ $produk->kategori->nama ?? '-' }}</td>
                                    <td>
                                        @if($produk->gambar)
                                            <img src="{{ Storage::url('/' . $produk->gambar) }}" alt="Gambar Produk" width="100">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.add') }}" method="POST" class="d-inline beli-form">
                                            @csrf
                                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                            <button type="submit" class="btn btn-sm btn-primary">Beli</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">Produk tidak ditemukan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.beli-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Tambah ke keranjang?',
                text: 'Produk ini akan ditambahkan ke keranjang Anda.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, beli',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@endsection
