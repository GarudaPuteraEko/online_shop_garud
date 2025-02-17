@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

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
                            <td>{{ $produk->harga }}</td>
                            <td>
                                <form action>
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $produk->id }}"/>
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
