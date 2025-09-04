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

  public function process(Request $request)
{
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

    $order = Order::create([
        'user_id' => Auth::id(),
        'total' => $total
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
}
