@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow rounded-4">
        <div class="card-header bg-dark text-white border-bottom">
            <h5 class="mb-0 fw-semibold">Keranjang Belanja</h5>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(count($cartItems) > 0)
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->produk->nama }}</td>
                                <td>{{ $item->produk->kategori->nama ?? '-' }}</td>
                                <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="confirmDelete(event)">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><strong>Total</strong></td>
                            <td></td>
                            <td colspan="2"><strong>Rp {{ number_format($cartItems->sum(fn($item) => $item->produk->harga), 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>

                <form action="{{ route('cart.checkout') }}" method="POST" id="checkout-form">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="confirmCheckout(event)">Checkout</button>
                </form>
            @else
                <p>Keranjang masih kosong.</p>
            @endif

            <a href="{{ route('home') }}" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>
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
            text: 'Produk ini akan dihapus dari keranjang Anda.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.closest('form').submit();
            }
        });
    }

    function confirmCheckout(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Checkout?',
            text: 'Apakah Anda yakin ingin melanjutkan ke proses checkout?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Checkout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('checkout-form').submit();
            }
        });
    }
</script>
@endsection
