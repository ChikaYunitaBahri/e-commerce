<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Middleware untuk mengatur izin akses berdasarkan role.
     */
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('role:Admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
        // Tambahkan log untuk debugging
        //\Log::info('Middleware role:Admin diterapkan');
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Menampilkan detail produk (dapat diakses oleh semua user).
     */
    public function show(Product $product)
    {
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
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        $product->update($validated);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Menghapus produk dari database (hanya untuk Admin).
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
