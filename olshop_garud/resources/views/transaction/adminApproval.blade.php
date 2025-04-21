@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Approval Transaksi') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Pembeli</th>
                                <th>Kode Produk</th>
                                <th>Harga</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->kode_produk }}</td>
                                <td>Rp {{ number_format($transaction->harga, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <td>{{ ucfirst($transaction->status) }}</td>
                                <td>
                                    @if($transaction->status == 'pending')
                                    <form action="{{ route('admin.transaction.approve', $transaction->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.transaction.reject', $transaction->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('adminHome') }}" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
