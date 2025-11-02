<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; // ✅ Tambahkan baris ini
use App\Models\OrderItem; // jika perlu

class Order extends Model
{
    protected $fillable = ['user_id', 'total', 'payment_method', 'payment_status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPaymentMethodNameAttribute()
    {
        $methods = [
            'cash' => 'Cash (Tunai)',
            'bank_transfer' => 'Transfer Bank',
            'gopay' => 'GoPay',
            'ovo' => 'OVO',
            'dana' => 'DANA',
            'shopee_pay' => 'ShopeePay'
        ];

        return $methods[$this->payment_method] ?? ucfirst(str_replace('_', ' ', $this->payment_method));
    }

    public function getPaymentStatusBadgeAttribute()
    {
        $statuses = [
            'pending' => '<span class="badge bg-warning">⏳ Menunggu Pembayaran</span>',
            'awaiting_payment' => '<span class="badge bg-info">⏰ Menunggu Konfirmasi</span>',
            'paid' => '<span class="badge bg-success">✅ Sudah Dibayar</span>',
            'failed' => '<span class="badge bg-danger">❌ Gagal</span>',
            'cancelled' => '<span class="badge bg-secondary">🚫 Dibatalkan</span>'
        ];

        return $statuses[$this->payment_status] ?? '<span class="badge bg-secondary">' . ucfirst($this->payment_status) . '</span>';
    }
}
