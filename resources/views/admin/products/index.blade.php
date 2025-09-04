@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
<div class="container">
    <h1>Daftar Produk</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.products.create') }}" class="btn btn-success mb-3">Tambah Produk</a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th style="width: 160px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td style="width: 100px;">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Gambar Produk" class="img-fluid rounded" style="max-height: 70px;">
                        @else
                            <span class="text-muted fst-italic">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>Rp{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus produk ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center">Belum ada produk.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
