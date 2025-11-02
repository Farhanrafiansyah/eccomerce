<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function show()
    {
        $products = Product::all();
        return view('checkout.form', compact('products'));
    }

    public function showProduct($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Check if product has stock
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Produk ini sedang habis stok.');
        }
        
        return view('checkout.single-product', compact('product'));
    }

  public function process(Request $request)
{
    // Validate payment method
    $request->validate([
        'payment_method' => 'required|in:cash,bank_transfer,gopay,ovo,dana,shopee_pay'
    ]);

    $total = 0;
    $items = [];

    foreach ($request->input('quantities', []) as $productId => $qty) {
        if ($qty > 0) {
            $product = Product::find($productId);

            if ($product) {
                if ($product->stock < $qty) {
                    return redirect()->back()->with('error', "Stok untuk {$product->name} tidak cukup.");
                }

                $total += $product->price * $qty;
                $items[] = [
                    'product' => $product,
                    'quantity' => $qty,
                    'price' => $product->price
                ];
            }
        }
    }

    if (empty($items)) {
        return redirect()->back()->with('error', 'Tidak ada produk yang dipilih.');
    }

    // Determine payment status based on payment method
    $paymentStatus = ($request->payment_method === 'cash') ? 'pending' : 'awaiting_payment';

    $order = Order::create([
        'user_id' => Auth::id(),
        'total' => $total,
        'payment_method' => $request->payment_method,
        'payment_status' => $paymentStatus
    ]);

    foreach ($items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['product']->id,
            'quantity' => $item['quantity'],
            'price' => $item['price']
        ]);

        $item['product']->stock -= $item['quantity'];
        $item['product']->save();
    }

    // Ubah redirect ke halaman sukses
    return redirect()->route('checkout.success', $order->id);
}

public function processSingleProduct(Request $request)
{
    // Validate payment method and product data
    $request->validate([
        'payment_method' => 'required|in:cash,bank_transfer,gopay,ovo,dana,shopee_pay',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1'
    ]);

    $product = Product::findOrFail($request->product_id);
    $quantity = $request->quantity;

    // Check stock availability
    if ($product->stock < $quantity) {
        return redirect()->back()->with('error', "Stok untuk {$product->name} tidak cukup. Stok tersisa: {$product->stock}");
    }

    $total = $product->price * $quantity;

    // Determine payment status based on payment method
    $paymentStatus = ($request->payment_method === 'cash') ? 'pending' : 'awaiting_payment';

    $order = Order::create([
        'user_id' => Auth::id(),
        'total' => $total,
        'payment_method' => $request->payment_method,
        'payment_status' => $paymentStatus
    ]);

    // Create order item
    OrderItem::create([
        'order_id' => $order->id,
        'product_id' => $product->id,
        'quantity' => $quantity,
        'price' => $product->price
    ]);

    // Update product stock
    $product->stock -= $quantity;
    $product->save();

    return redirect()->route('checkout.success', $order->id);
}
}
