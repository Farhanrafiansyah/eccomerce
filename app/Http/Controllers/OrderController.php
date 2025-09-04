<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'cart'  => 'required|array|min:1',
            'cart.*.id'       => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'cart.*.price'    => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Simpan order
            $order = Order::create([
                'user_id' => auth()->id(),
                'total'   => $request->total,
            ]);

            // Simpan item order
            foreach ($request->cart as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }

            DB::commit();

            return redirect()->route('checkout.success', $order->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout gagal: ' . $e->getMessage());
        }
    }

    public function checkoutSuccess($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('checkout-success', compact('order'));
    }
}
