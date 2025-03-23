@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Keranjang Belanja</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
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
                    <a href="{{ route('cart.edit', $cart->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('cart.destroy', $cart->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini dari keranjang?');">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
