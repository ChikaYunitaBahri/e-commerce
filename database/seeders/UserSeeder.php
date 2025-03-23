<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating Admin User
        $admin = User::create([
            'name' => 'Chika',
            'email' => 'admin@roles.id',
            'password' => Hash::make('Chika@2023')
        ]);
        $admin->assignRole('Admin');

        // Creating User
        $user = User::create([
            'name' => 'Dina',
            'email' => 'user@roles.id',
            'password' => Hash::make('Dina@2023')
            ]);
        $user->assignRole('User');
    }
}
