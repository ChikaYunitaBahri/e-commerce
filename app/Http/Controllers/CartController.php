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
     * Middleware untuk memastikan user sudah login.
     */
    public function __construct()
    {
        $this->middleware('auth');
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
     * Menyimpan produk ke dalam keranjang.
     */
    public function store(Request $request)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Pastikan user memiliki izin 'add-to-cart'
        if (!Gate::allows('add-to-cart')) {
            return abort(403, 'Anda tidak memiliki izin untuk menambahkan produk ke keranjang.');
        }

        // Ambil produk
        $product = Product::findOrFail($request->product_id);

        // Cek apakah produk sudah ada di keranjang user
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            // Jika produk sudah ada, hanya tambahkan jumlahnya
            $cartItem->increment('quantity', $request->quantity);
        } else {
            // Jika belum ada, tambahkan ke keranjang
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
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
    public function edit(Cart $cart)
    {
        if (!Gate::allows('update', $cart)) {
            return abort(403);
        }

        return view('cart.edit', compact('cart'));
    }

    /**
     * Memperbarui jumlah produk di dalam keranjang.
     */
    public function update(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        if (!Gate::allows('update', $cart)) {
            return abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari keranjang.
     */
    public function destroy($id)
    {
        $cart = Cart::findOrFail($id);

        if (!Gate::allows('delete', $cart)) {
            return abort(403);
        }

        $cart->delete();
        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
