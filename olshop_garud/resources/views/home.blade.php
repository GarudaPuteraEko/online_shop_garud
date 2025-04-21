@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Tampilkan pesan sukses jika ada --}}
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                
                <div class="my-1">
                    <a href="{{ route('cart.show') }}" class="btn btn-warning">Lihat Keranjang</a>
                </div>
                <div class="my-1">
                    <a href="{{ route('transaction.approval') }}" class="btn btn-success">Lihat Approval</a>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Kode Produk</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produks as $produk)
                        <tr>
                            <td>{{ $produk->kode_produk }}</td>
                            <td>{{ $produk->nama }}</td>
                            <td>Rp{{ number_format($produk->harga) }}</td>
                            <td>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                    <button type="submit" class="btn btn-primary">Beli</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
@endsection
