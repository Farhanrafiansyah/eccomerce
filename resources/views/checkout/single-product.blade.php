<!DOCTYPE html>
<html>
<head>
    <title>Checkout - {{ $product->name }}</title>
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
        .product-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .quantity-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: #007bff;
            color: white;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .quantity-btn:hover {
            background: #0056b3;
            transform: scale(1.1);
        }
        .quantity-input {
            width: 80px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            border: 2px solid #dee2e6;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="mb-4 fw-bold text-primary text-center">🛒 Checkout Produk</h1>

            {{-- Tampilkan pesan sukses atau error --}}
            @if (session('success'))
                <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
            @endif

            <form action="{{ route('checkout.process.single') }}" method="POST" id="checkoutForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                {{-- Product Information Card --}}
                <div class="card shadow-lg border-0 rounded-4 mb-4">
                    <div class="card-header product-card text-center py-4">
                        <h3 class="mb-0">📱 {{ $product->name }}</h3>
                    </div>
                    <div class="card-body p-4">
                        <div class="row align-items-center">
                            <div class="col-md-4 text-center">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-fluid rounded-3 shadow"
                                     style="max-height: 200px; object-fit: cover;"
                                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop&auto=format';">
                            </div>
                            <div class="col-md-8">
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>💰 Harga:</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="fs-5 fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-6">
                                        <strong>📦 Stok:</strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="badge bg-info fs-6">{{ $product->stock }} tersedia</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <strong>🔢 Jumlah:</strong>
                                    </div>
                                    <div class="col-6">
                                        <div class="quantity-controls">
                                            <button type="button" class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="form-control quantity-input" onchange="updateTotal()" data-price="{{ $product->price }}" data-max-stock="{{ $product->stock }}">
                                            <button type="button" class="quantity-btn" onclick="changeQuantity(1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        {{-- Total Price Display --}}
                        <div class="text-center mt-4 p-3 bg-light rounded-3">
                            <h4 class="mb-0">💳 Total: <span id="totalPrice" class="text-primary fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span></h4>
                        </div>
                    </div>
                </div>

                {{-- Payment Method Selection --}}
                <div class="card shadow-lg border-0 rounded-4 mb-4">
                    <div class="card-header bg-primary text-white text-center py-3">
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
                                        <span class="me-2"></span>
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
                                        <span class="me-2"></span>
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
                                        <span class="me-2"></span>
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
                                        <span class="me-2"> </span>
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

                {{-- Action Buttons --}}
                <div class="text-center">
                    <a href="{{ url('/') }}" class="btn btn-secondary btn-lg px-4 py-2 me-3">
                        ← Kembali Belanja
                    </a>
                    <button type="submit" class="btn btn-success btn-lg px-5 py-2 fw-bold">
                        🛒 Beli Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const quantityInput = document.getElementById('quantity');
    const productPrice = parseInt(quantityInput.dataset.price);
    const maxStock = parseInt(quantityInput.dataset.maxStock);

    function changeQuantity(change) {
        const quantityInput = document.getElementById('quantity');
        let newQuantity = parseInt(quantityInput.value) + change;
        
        if (newQuantity < 1) newQuantity = 1;
        if (newQuantity > maxStock) newQuantity = maxStock;
        
        quantityInput.value = newQuantity;
        updateTotal();
    }

    function updateTotal() {
        const quantity = parseInt(document.getElementById('quantity').value);
        const total = productPrice * quantity;
        document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    // Add click events to payment options
    document.querySelectorAll('.payment-option').forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>