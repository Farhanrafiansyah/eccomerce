
@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="container">
    <h1>Edit Produk</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Harga (Rp)</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required min="0" step="1000">
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Produk Saat Ini</label><br>
            @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="img-thumbnail" style="max-height: 120px;">
            @else
                <p class="text-muted fst-italic">Tidak ada gambar</p>
            @endif
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Ganti Gambar Produk (opsional)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/*">
            <small class="form-text text-muted">Upload gambar baru untuk mengganti yang lama.</small>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.products') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
