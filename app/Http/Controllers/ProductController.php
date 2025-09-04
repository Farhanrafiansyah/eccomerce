<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        // Ambil semua produk dari DB
        $products = Product::all();

        // Kirim data ke view 'home'
        return view('home', compact('products'));
    }
}
