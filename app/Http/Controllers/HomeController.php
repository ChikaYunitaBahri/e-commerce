<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Middleware untuk memastikan user sudah login.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan dashboard dengan daftar produk & keranjang belanja.
     */
    public function index()
    {
        $products = Product::latest()->get();
        $cartItems = Auth::check() ? Cart::where('user_id', Auth::id())->with('product')->get() : collect();

        return view('home', compact('products', 'cartItems'));
    }
}
