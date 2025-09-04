<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
    <h2>Checkout Produk</h2>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div style="color:red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <label>Nama:</label><br>
        <input type="text" name="name" value="{{ old('name') }}" required><br><br>

        <label>Alamat Pengiriman:</label><br>
        <textarea name="address" required>{{ old('address') }}</textarea><br><br>

        <label>Nomor Telepon:</label><br>
        <input type="text" name="phone" value="{{ old('phone') }}" required><br><br>

        <button type="submit">Bayar Sekarang</button>
    </form>
</body>
</html>
