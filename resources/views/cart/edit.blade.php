@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Jumlah Produk</h2>

    <form action="{{ route('cart.update', $cart->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label for="quantity" class="form-label">Jumlah</label>
            <input type="number" class="form-control" name="quantity" value="{{ $cart->quantity }}" min="1">
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('cart.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

# The edit.blade.php file is a view file that will be displayed when the user wants to edit the quantity of a product in the cart. The user can change the quantity of the product and save it. If the user clicks the "Simpan" button, the form will be submitted to the cart.update route. If the user clicks the "Batal" button, the user will be redirected to the cart.index route. The form consists of a quantity input field and two buttons: "Simpan" and "Batal". The quantity input field is a number input field with a minimum value of 1. The value of the quantity input field is set to the current quantity of the product in the cart. The form uses the PATCH method to submit the form data. The form also includes a CSRF token field to protect the form from cross-site request forgery (CSRF) attacks. The form is displayed inside a container with a title "Edit Jumlah Produk".