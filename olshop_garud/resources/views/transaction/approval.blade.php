@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow rounded-4">
        <div class="card-header bg-dark text-white border-bottom">
            <h5 class="mb-0 fw-semibold">Approval Transaksi</h5>
        </div>

        <div class="card-body">
            @if($transactions->isEmpty())
                <p class="text-center text-muted">Tidak ada transaksi ditemukan.</p>
            @else
                <table class="table table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kode Produk</th>
                            <th>Nama Produk</th>
                            <th>Kategori</th>
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
                                <td>{{ $transaction->produk->nama ?? '-' }}</td>
                                <td>{{ $transaction->produk->kategori->nama ?? 'Kategori Tidak Tersedia' }}</td>
                                <td>Rp {{ number_format($transaction->harga, 0, ',', '.') }}</td>
                                <td>{{ $transaction->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge 
                                        {{ $transaction->status == 'approved' ? 'bg-success' : 
                                           ($transaction->status == 'rejected' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($transaction->status == 'approved')
                                        <a href="{{ route('transaction.download', $transaction->id) }}" class="btn btn-success btn-sm" onclick="confirmDownload(event)">Download Bukti</a>
                                    @elseif($transaction->status == 'pending')
                                        <form action="{{ route('transaction.cancel', $transaction->id) }}" method="POST" style="display:inline;" onsubmit="return confirmCancel(event)">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-sm">Batal</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Tidak Tersedia</span>
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
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmCancel(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Batalkan Transaksi?',
            text: 'Apakah Anda yakin ingin membatalkan transaksi ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Batalkan',
            cancelButtonText: 'Tidak Jadi'
        }).then((result) => {
            if (result.isConfirmed) {
                event.target.submit();
            }
        });
    }

    function confirmDownload(event) {
        event.preventDefault();
        Swal.fire({
            title: 'Download Bukti Transaksi?',
            text: 'Apakah Anda ingin mendownload bukti transaksi ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, Download',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = event.target.href;
            }
        });
    }
</script>
@endsection
