<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        $permissions = [
            'create-user',
            'edit-user',
            'delete-user',
            'create-product',
            'edit-product',
            'delete-product',
            'view-product',
            'buy-product',
            'view-cart', // Menampilkan keranjang
            'add-to-cart', // Menambah produk ke keranjang
            'update-cart', // Mengubah isi keranjang
            'delete-cart' // Menghapus item dari keranjang
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
