@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card border-0 shadow rounded-4">
                {{-- Header dengan latar belakang hitam --}}
                <div class="card-header bg-dark text-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-semibold">Dashboard Admin</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('produk.create') }}" class="btn btn-sm btn-outline-primary">Tambah Produk</a>
                        <a href="{{ route('transaction.adminApproval') }}" class="btn btn-sm btn-outline-success">Lihat Approval Transaksi</a>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Filter Form --}}
                    <form method="GET" action="{{ route('adminHome') }}" class="row g-3 align-items-end mb-4">
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

                    {{-- Produk Table --}}
                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">Kode Produk</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Kategori</th>
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
                                    <td class="text-center">
                                        <a href="{{ route('produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete(event)">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Produk tidak ditemukan.</td>
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
    function confirmDelete(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Produk?',
            text: 'Apakah Anda yakin ingin menghapus produk ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }
</script>
@endsection
