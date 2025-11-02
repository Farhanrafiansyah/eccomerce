<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
    <!-- Pakai tema Lux Bootswatch -->
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/lux/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        .payment-option {
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
        }
        .payment-option:hover {
            border-color: #007bff;
            background-color: #f8f9fa;
        }
        .payment-option input[type="radio"]:checked + label {
            background-color: #e7f3ff;
            border-color: #007bff;
        }
        .form-check-input:checked {
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
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
                        <img src="{{ $product->image_url }}" 
                             alt="{{ $product->name }}" 
                             class="card-img-top rounded-top" 
                             style="height: 180px; object-fit: cover;"
                             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop&auto=format';">
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

        {{-- Payment Method Selection --}}
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card shadow border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top">
                        <h5 class="mb-0 fw-bold">🏦 Pilih Metode Pembayaran</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="cash" value="cash" checked>
                                    <label class="form-check-label d-flex align-items-center" for="cash">
                                        <span class="me-2">💵</span>
                                        <div>
                                            <strong>Cash (Tunai)</strong>
                                            <small class="d-block text-muted">Bayar langsung saat pengambilan</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer" value="bank_transfer">
                                    <label class="form-check-label d-flex align-items-center" for="bank_transfer">
                                        <span class="me-2">🏦</span>
                                        <div>
                                            <strong>Transfer Bank</strong>
                                            <small class="d-block text-muted">BCA, BNI, Mandiri, BRI</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="gopay" value="gopay">
                                    <label class="form-check-label d-flex align-items-center" for="gopay">
                                        <span class="me-2">💚</span>
                                        <div>
                                            <strong>GoPay</strong>
                                            <small class="d-block text-muted">Pembayaran digital Gojek</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="ovo" value="ovo">
                                    <label class="form-check-label d-flex align-items-center" for="ovo">
                                        <span class="me-2">💜</span>
                                        <div>
                                            <strong>OVO</strong>
                                            <small class="d-block text-muted">Dompet digital OVO</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="dana" value="dana">
                                    <label class="form-check-label d-flex align-items-center" for="dana">
                                        <span class="me-2">💙</span>
                                        <div>
                                            <strong>DANA</strong>
                                            <small class="d-block text-muted">Dompet digital DANA</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="payment_method" id="shopee_pay" value="shopee_pay">
                                    <label class="form-check-label d-flex align-items-center" for="shopee_pay">
                                        <span class="me-2">🧡</span>
                                        <div>
                                            <strong>ShopeePay</strong>
                                            <small class="d-block text-muted">Dompet digital Shopee</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success px-4 py-2 fw-bold">Checkout</button>
        </div>
    </form>
</div>
</body>
</html>
