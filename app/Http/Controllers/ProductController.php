<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * Middleware untuk mengatur izin akses berdasarkan role.
     */
    public function __construct()
    {
        $this->middleware('auth'); // Pastikan user login
        $this->middleware('role:Admin')->except(['index', 'show']);
    }

    /**
     * Menampilkan daftar produk (dapat diakses oleh semua user).
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan form tambah produk (hanya untuk Admin).
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Menyimpan produk baru ke database (hanya untuk Admin).
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail produk (dapat diakses oleh semua user).
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk (hanya untuk Admin).
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Memperbarui produk di database (hanya untuk Admin).
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database (hanya untuk Admin).
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
