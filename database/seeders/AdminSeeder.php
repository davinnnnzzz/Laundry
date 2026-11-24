<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name'            => 'Admin Laundry',
            'email'           => 'admin@laundry.test',
            'whatsapp_number' => '081234567890',
            'role'            => 'admin',
            'password'        => Hash::make('password123'),
        ]);

        // Kasir
        User::create([
            'name'            => 'Kasir Laundry',
            'email'           => 'kasir@laundry.test',
            'whatsapp_number' => '081234567891',
            'role'            => 'kasir',
            'password'        => Hash::make('password123'),
        ]);

        // Sample Customer
        User::create([
            'name'            => 'Budi Santoso',
            'email'           => 'customer@laundry.test',
            'whatsapp_number' => '081234567890',
            'role'            => 'customer',
            'password'        => Hash::make('password123'),
        ]);
    }
}
