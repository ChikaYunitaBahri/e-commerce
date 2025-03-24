<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CartController extends Controller
{
    /**
     * Middleware untuk mengatur izin akses berdasarkan role.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan user login
        $this->middleware('role:User'); // Hanya untuk role User
    }

    /**
     * Menampilkan daftar produk dalam keranjang.
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Menambahkan produk ke keranjang.
     */
    public function addToCart(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        Cart::updateOrCreate(
            ['user_id' => auth()->id(), 'product_id' => $product->id],
            ['quantity' => $validated['quantity']]
        );

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Menampilkan detail satu item di keranjang.
     */
    public function show(Cart $cart)
    {
        if (!Gate::allows('view', $cart)) {
            return abort(403);
        }

        return view('cart.show', compact('cart'));
    }

    /**
     * Menampilkan form edit untuk jumlah produk di keranjang.
     */
    public function edit($id)
    {
        $cart = Cart::findOrFail($id);

        if (auth()->id() !== $cart->user_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('cart.edit', compact('cart'));
    }

    /**
     * Mengedit jumlah produk di keranjang.
     */
    public function update(Request $request, Cart $cart)
    {
        $this->authorize('update', $cart);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->update(['quantity' => $validated['quantity']]);
        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui');
    }

    /**
     * Menghapus produk dari keranjang.
     */
    public function destroy(Cart $cart)
    {
        $this->authorize('delete', $cart);

        $cart->delete();
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang');
    }
}
