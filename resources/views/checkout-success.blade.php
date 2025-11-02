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

            {{-- Payment Method Information --}}
            <div class="alert alert-info mt-4">
                <h5 class="alert-heading">💳 Metode Pembayaran</h5>
                <p class="mb-2"><strong>Metode:</strong> 
                    @switch($order->payment_method)
                        @case('cash')
                            💵 Cash (Tunai)
                            @break
                        @case('bank_transfer')
                            🏦 Transfer Bank
                            @break
                        @case('gopay')
                             GoPay
                            @break
                        @case('ovo')
                             OVO
                            @break
                        @case('dana')
                             DANA
                            @break
                        @case('shopee_pay')
                             ShopeePay
                            @break
                        @default
                            {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                    @endswitch
                </p>
                <p class="mb-0"><strong>Status:</strong> 
                    @if($order->payment_status === 'pending')
                        <span class="badge bg-warning">⏳ Menunggu Pembayaran</span>
                    @elseif($order->payment_status === 'awaiting_payment')
                        <span class="badge bg-info">⏰ Menunggu Konfirmasi</span>
                    @elseif($order->payment_status === 'paid')
                        <span class="badge bg-success">✅ Sudah Dibayar</span>
                    @else
                        <span class="badge bg-secondary">{{ ucfirst($order->payment_status) }}</span>
                    @endif
                </p>
            </div>

            {{-- Payment Instructions --}}
            @if($order->payment_method !== 'cash')
                <div class="alert alert-warning mt-3">
                    <h6 class="alert-heading">📋 Instruksi Pembayaran</h6>
                    @switch($order->payment_method)
                        @case('bank_transfer')
                            <p class="mb-2">Silakan transfer ke salah satu rekening berikut:</p>
                            <ul class="list-unstyled text-start">
                                <li><strong>BCA:</strong> 972739492 (a.n. Farhan R)</li>
                                <li><strong>BNI:</strong> 727367276 (a.n. Toko Abas)</li>
                                <li><strong>Mandiri:</strong> 3848290498 (a.n. Toko Online)</li>
                                <li><strong>BRI:</strong> 2468135790 (a.n. Toko Online)</li>
                            </ul>
                            <p class="mb-0"><small>💡 Jangan lupa sertakan ID Pesanan <strong>{{ $order->id }}</strong> sebagai berita transfer</small></p>
                            @break
                        @case('gopay')
                            <p class="mb-2">Scan QR Code berikut atau transfer ke nomor GoPay:</p>
                            <p><strong>Nomor GoPay:</strong> 0895-1756-4732</p>
                            <p class="mb-0"><small>💡 Sertakan ID Pesanan <strong>{{ $order->id }}</strong> pada catatan transfer</small></p>
                            @break
                        @case('ovo')
                            <p class="mb-2">Transfer melalui aplikasi OVO ke nomor:</p>
                            <p><strong>Nomor OVO:</strong> 0812-9937-565</p>
                            <p class="mb-0"><small>💡 Sertakan ID Pesanan <strong>{{ $order->id }}</strong> pada catatan transfer</small></p>
                            @break
                        @case('dana')
                            <p class="mb-2">Transfer melalui aplikasi DANA ke nomor:</p>
                            <p><strong>Nomor DANA:</strong> 0812-3456-7890</p>
                            <p class="mb-0"><small>💡 Sertakan ID Pesanan <strong>{{ $order->id }}</strong> pada catatan transfer</small></p>
                            @break
                        @case('shopee_pay')
                            <p class="mb-2">Transfer melalui aplikasi ShopeePay ke nomor:</p>
                            <p><strong>Nomor ShopeePay:</strong> 0812-3456-7890</p>
                            <p class="mb-0"><small>💡 Sertakan ID Pesanan <strong>{{ $order->id }}</strong> pada catatan transfer</small></p>
                            @break
                    @endswitch
                </div>
            @endif

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

            <h5 class="mt-3">Total: Rp {{ number_format($order->total, 0, ',', '.') }}</h5>

            @if($order->payment_method === 'cash')
                <div class="alert alert-success mt-3">
                    <p class="mb-0">💰 <strong>Pembayaran Cash:</strong> Silakan siapkan uang tunai sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong> saat pengambilan barang.</p>
                </div>
            @endif

            <div class="mt-4">
                <a href="{{ url('/') }}" class="btn btn-primary me-2">🏠 Kembali ke Beranda</a>
                @if($order->payment_method !== 'cash')
                    <button class="btn btn-success" onclick="alert('Fitur konfirmasi pembayaran akan segera tersedia!')">✅ Konfirmasi Pembayaran</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
