
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container">
    <h1>Halaman admin</h1>
    <p>Selamat kembali Admin.</p>
    <a href="{{ route('admin.products') }}" class="btn btn-primary">kelola Produk</a>
</div>
@endsection
