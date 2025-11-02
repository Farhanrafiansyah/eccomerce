@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">🛒 Manajemen Pesanan</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Tanggal</th>
                                        <th>Metode Bayar</th>
                                        <th>Status Bayar</th>
                                        <th>Total</th>
                                        <th>Items</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td><strong>#{{ $order->id }}</strong></td>
                                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @switch($order->payment_method)
                                                    @case('cash')
                                                        💵 Cash
                                                        @break
                                                    @case('bank_transfer')
                                                        🏦 Transfer Bank
                                                        @break
                                                    @case('gopay')
                                                        💚 GoPay
                                                        @break
                                                    @case('ovo')
                                                        💜 OVO
                                                        @break
                                                    @case('dana')
                                                        💙 DANA
                                                        @break
                                                    @case('shopee_pay')
                                                        🧡 ShopeePay
                                                        @break
                                                    @default
                                                        {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}
                                                @endswitch
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.orders.payment-status', $order) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="payment_status" class="form-select form-select-sm" 
                                                            onchange="this.form.submit()" 
                                                            style="width: 150px;">
                                                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>
                                                            ⏳ Pending
                                                        </option>
                                                        <option value="awaiting_payment" {{ $order->payment_status === 'awaiting_payment' ? 'selected' : '' }}>
                                                            ⏰ Awaiting Payment
                                                        </option>
                                                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>
                                                            ✅ Paid
                                                        </option>
                                                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>
                                                            ❌ Failed
                                                        </option>
                                                        <option value="cancelled" {{ $order->payment_status === 'cancelled' ? 'selected' : '' }}>
                                                            🚫 Cancelled
                                                        </option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td><strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong></td>
                                            <td>
                                                <button class="btn btn-sm btn-info" type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#items-{{ $order->id }}" 
                                                        aria-expanded="false">
                                                    {{ $order->items->count() }} item(s)
                                                </button>
                                            </td>
                                            <td>
                                                <a href="{{ route('checkout.success', $order) }}" 
                                                   class="btn btn-sm btn-outline-primary" 
                                                   target="_blank">
                                                    👁️ View
                                                </a>
                                            </td>
                                        </tr>
                                        <tr class="collapse" id="items-{{ $order->id }}">
                                            <td colspan="8">
                                                <div class="bg-light p-3 rounded">
                                                    <h6>Detail Items:</h6>
                                                    <ul class="list-unstyled mb-0">
                                                        @foreach($order->items as $item)
                                                            <li>
                                                                <strong>{{ $item->product->name }}</strong> - 
                                                                Qty: {{ $item->quantity }} × 
                                                                Rp {{ number_format($item->price, 0, ',', '.') }} = 
                                                                <strong>Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</strong>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <h5 class="text-muted">Belum ada pesanan</h5>
                            <p class="text-muted">Pesanan akan muncul di sini ketika customer melakukan checkout.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection