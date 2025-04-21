@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Approval Transaksi') }}</div>

                <div class="card-body">
                    @if($transactions->isEmpty())
                        <p>Tidak ada transaksi ditemukan.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
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
                                    <td>{{ $transaction->kode_produk }}</td>
                                    <td>Rp {{ number_format($transaction->harga, 0, ',', '.') }}</td>
                                    <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                    <td>{{ ucfirst($transaction->status) }}</td>
                                    <td>
                                        @if($transaction->status == 'approved')
                                            <a href="{{ route('transaction.download', $transaction->id) }}" class="btn btn-success btn-sm">Download Bukti</a>
                                        @elseif($transaction->status == 'pending')
                                            <form action="{{ route('transaction.cancel', $transaction->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">Batal</button>
                                            </form>
                                        @else
                                            <span class="text-danger">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="{{ route('home') }}" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
