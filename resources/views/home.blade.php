@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h5 class="mb-3">{{ __('Welcome to the E-Commerce Dashboard!') }}</h5>

                    <!-- Tombol Kelola Produk untuk Admin -->
                    @can('create', App\Models\Product::class)
                        <a class="btn btn-warning mb-3" href="{{ route('products.index') }}">
                            <i class="bi bi-bag"></i> Kelola Produk
                        </a>
                    @endcan

                    <!-- Menampilkan Daftar Produk -->
                    <div class="row">
                        @foreach ($products as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <img src="https://via.placeholder.com/300" class="card-img-top" alt="Product Image">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ Str::limit($product->description, 50) }}</p>
                                        <p class="card-text"><strong>Rp {{ number_format($product->price, 2) }}</strong></p>

                                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Lihat Detail
                                        </a>

                                        @auth
                                            <form action="{{ route('cart.store') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-cart-plus"></i> Tambah ke Keranjang
                                                </button>
                                            </form>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Menampilkan Keranjang Belanja -->
                    @auth
                        <h4 class="mt-4">Keranjang Belanja</h4>
                        @if ($cartItems->isEmpty())
                            <p class="text-muted">Keranjang belanja masih kosong.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Produk</th>
                                        <th>Jumlah</th>
                                        <th>Harga</th>
                                        <th>Total</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cartItems as $cart)
                                        <tr>
                                            <td>{{ $cart->product->name }}</td>
                                            <td>{{ $cart->quantity }}</td>
                                            <td>Rp {{ number_format($cart->product->price, 2) }}</td>
                                            <td>Rp {{ number_format($cart->quantity * $cart->product->price, 2) }}</td>
                                            <td>
                                                <a href="{{ route('cart.edit', $cart->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini dari keranjang?');">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
