@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Produk</h1>

    {{-- Notifikasi error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama Produk --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Nama Produk</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        {{-- Harga --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Harga</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required>
        </div>

        {{-- Stok --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Stok</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
        </div>

        {{-- Gambar Lama --}}
        @if($product->image)
            <div class="mb-3">
                <label class="form-label fw-bold">Gambar Saat Ini</label>
                <div>
                    <img src="{{ asset('storage/'.$product->image) }}" alt="Gambar Produk" class="img-thumbnail" style="max-width: 200px;">
                </div>
            </div>
        @endif

        {{-- Ganti Gambar --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Ganti Gambar (Opsional)</label>
            <input type="file" name="image" class="form-control">
        </div>

        {{-- Tombol --}}
        <div class="mt-4">
            <button class="btn btn-primary" type="submit">Update</button>
            <a href="{{ route('admin.products') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
