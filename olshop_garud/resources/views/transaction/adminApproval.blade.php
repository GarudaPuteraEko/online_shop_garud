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
                            <th>Nama Pembeli</th>
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
                                <td>{{ $transaction->user->name }}</td>
                                <td>{{ $transaction->kode_produk }}</td>
                                <td>{{ $transaction->produk->nama ?? '-' }}</td>
                                <td>{{ $transaction->produk->kategori->nama ?? '-' }}</td>
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
                                    @if($transaction->status == 'pending')
                                        <form action="{{ route('admin.transaction.approve', $transaction->id) }}" method="POST" class="d-inline approve-form">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.transaction.reject', $transaction->id) }}" method="POST" class="d-inline reject-form">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    @else
                                        <span class="text-muted">Tidak tersedia</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="{{ route('adminHome') }}" class="btn btn-secondary mt-3">← Kembali ke Halaman Utama</a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.approve-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Approve Transaksi?',
                text: 'Anda yakin ingin menyetujui transaksi ini?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

    document.querySelectorAll('.reject-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Tolak Transaksi?',
                text: 'Apakah Anda yakin ingin menolak transaksi ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
