<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi PDF</title>
</head>
<body>
    <h1>Detail Transaksi</h1>
    <p>Kode Produk: {{ $transaction->kode_produk }}</p>
    <p>Nama Pembeli: {{ $transaction->nama_user }}</p>
    <p>Status: {{ $transaction->status }}</p>
    <p>Tanggal Transaksi: {{ $transaction->created_at }}</p>

    <!-- Menampilkan kategori -->
    <p>Kategori Produk: {{ $transaction->produk->kategori->nama ?? 'Kategori Tidak Tersedia' }}</p>
</body>
</html>
