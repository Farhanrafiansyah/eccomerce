{{-- resources/views/checkout/success.blade.php --}}
@extends('layouts.app')

@section('title', 'Checkout Berhasil')

@section('content')
<div class="container text-center py-5">
    <div class="card shadow p-4" style="max-width: 500px; margin: auto;">
        <div class="mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" 
                 class="text-success" width="80" height="80" fill="currentColor" 
                 viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.97 10.97l5-5-.708-.708L6.5 9.293 4.354 7.146l-.708.708 3 3z"/>
            </svg>
        </div>
        <h2 class="text-success">Checkout Berhasil!</h2>
        <p class="mt-2">Terima kasih sudah berbelanja di toko kami.</p>
        
        <div class="border p-3 my-3 text-start">
            <p><strong>ID Pesanan:</strong> {{ $order->id }}</p>
            <p><strong>Total Pembayaran:</strong> Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
        </div>

        <a href="{{ route('home') }}" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
</div>
@endsection
