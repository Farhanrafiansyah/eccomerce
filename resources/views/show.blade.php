<!DOCTYPE html>
<html>
<head>
    <title>Detail Produk</title>
</head>
<body>
    <h1>{{ $product->name }}</h1>

    <p><strong>Harga:</strong> Rp{{ number_format($product->price, 0, ',', '.') }}</p>

    <p><strong>Deskripsi:</strong> {{ $product->description }}</p>

    <p><strong>Stok:</strong> {{ $product->stock }}</p>

    <br>
    <a href="{{ url('/') }}">← Kembali ke daftar produk</a>
</body>
</html>
