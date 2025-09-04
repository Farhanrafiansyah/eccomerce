<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <!-- Pakai tema Lux Bootswatch -->
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/lux/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h1 class="mb-4 fw-bold text-primary text-center">Form Checkout</h1>

    {{-- Tampilkan pesan sukses atau error --}}
    @if (session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow border-0 rounded-4">
                        <img src="https://via.placeholder.com/150" 
                             alt="{{ $product->name }}" 
                             class="card-img-top rounded-top" 
                             style="height: 180px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold">{{ $product->name }}</h5>
                            <p class="card-text mb-2">Harga: <strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong></p>
                            <div class="mb-3">
                                <label for="qty_{{ $product->id }}" class="form-label fw-semibold">Jumlah:</label>
                                <input type="number" name="quantities[{{ $product->id }}]" id="qty_{{ $product->id }}" 
                                       class="form-control" value="1" min="0" max="{{ $product->stock }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success px-4 py-2 fw-bold">Checkout</button>
        </div>
    </form>
</div>
</body>
</html>
