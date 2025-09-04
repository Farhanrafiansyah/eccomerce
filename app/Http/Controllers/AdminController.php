<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class AdminController extends Controller
{
    /**
     * Dashboard Admin
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * List Produk
     */
    public function products()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Form Tambah Produk
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Simpan Produk Baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('products', 'public')
            : null;

        Product::create([
            'name'  => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Form Edit Produk
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update Produk
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        // Update data produk
        $product->name  = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        // Jika ada gambar baru
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Hapus Produk
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')
            ->with('success', 'Produk berhasil dihapus');
    }
}
