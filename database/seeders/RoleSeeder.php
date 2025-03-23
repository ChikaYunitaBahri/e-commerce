<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role Admin dan User
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $user = Role::firstOrCreate(['name' => 'User']);

        // Ambil semua permissions
        $allPermissions = Permission::pluck('name')->toArray();

        // Admin mendapatkan semua permission
        $admin->syncPermissions($allPermissions);

        // User hanya bisa melihat, membeli produk, dan mengelola keranjang
        $user->syncPermissions([
            'view-product',
            'buy-product',
            'view-cart',
            'add-to-cart',
            'update-cart',
            'delete-cart'
        ]);
    }
}
