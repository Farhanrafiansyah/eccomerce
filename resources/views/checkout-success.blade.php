@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body text-center">
            <h1 class="text-success">✅ Pesanan Berhasil!</h1>
            <p>Terima kasih, pesanan Anda sudah kami terima.</p>

            <h4 class="mt-4">Detail Pesanan</h4>
            <p><strong>ID Pesanan:</strong> {{ $order->id }}</p>
            <p><strong>Tanggal:</strong> {{ $order->created_at->format('d M Y H:i') }}</p>

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5 class="mt-3">Total: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</h5>

            <a href="{{ url('/') }}" class="btn btn-primary mt-3">Kembali ke Beranda</a>
        </div>
    </div>
</div>
@endsection
