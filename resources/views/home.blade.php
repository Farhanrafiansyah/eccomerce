<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Beranda - Toko Online</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap ganti ke Bootswatch Pulse -->
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/pulse/bootstrap.min.css" rel="stylesheet">


    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.18);
        }
        .btn {
            border-radius: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.9rem;
        }
        h2 {
            text-shadow: 1px 1px 3px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">



<!-- Navbar -->


<!-- Konten Utama -->
@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <h2 class="mb-4 fw-bold text-primary">Daftar Barang</h2>

    @if(session('success'))
        <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
    @endif

    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow border-0 rounded-3">
                    <img src="{{ asset('storage/' . $product->image) }}" 
                         class="card-img-top rounded-top" 
                         alt="{{ $product->name }}" 
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                        <p class="card-text">Harga: <strong>Rp{{ number_format($product->price, 0, ',', '.') }}</strong></p>

                        @if($product->stock > 0)
                            <p><span class="badge bg-success">Stok Tersisa: {{ $product->stock }}</span></p>
                        @else
                            <p><span class="badge bg-danger">Stok Habis</span></p>
                        @endif

                        <div class="mt-auto">
                            @auth
                                @if($product->stock > 0)
                                    <form action="{{ route('checkout.process') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantities[{{ $product->id }}]" value="1">
                                        <button class="btn btn-success w-100">Beli</button>
                                    </form>
                                @else
                                    <button class="btn btn-secondary w-100" disabled>Stok Habis</button>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary w-100">Login untuk Beli</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
