@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Keranjang Belanja</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(count($cartItems) > 0)
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item->produk->nama }}</td>
                    <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
                <tr>
                    <td><strong>Total</strong></td>
                    <td colspan="2"><strong>Rp {{ number_format($cartItems->sum(fn($item) => $item->produk->harga), 0, ',', '.') }}</strong></td>
                </tr>
            </tbody>
        </table>

        <form action="{{ route('cart.checkout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Checkout</button>
        </form>
    @else
        <p>Keranjang masih kosong.</p>
    @endif

    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>
</div>
@endsection
