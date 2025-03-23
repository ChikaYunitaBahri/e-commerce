@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Detail Produk</h2>

    <div class="card">
        <div class="card-body">
            <h3>{{ $product->name }}</h3>
            <p><strong>Deskripsi:</strong> {{ $product->description }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($product->price, 2) }}</p>
            <p><strong>Stok:</strong> {{ $product->stock }}</p>

            <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
