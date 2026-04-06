<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin JMI Krian
        User::create([
            'name' => 'Admin IT Krian',
            'email' => 'krian@onemed.co.id',
            'password' => Hash::make('password123'),
            'location' => 'JMI Krian, Sidoarjo'
        ]);

        // 2. Admin Mojoagung
        User::create([
            'name' => 'Admin IT Mojoagung',
            'email' => 'mojoagung@onemed.co.id',
            'password' => Hash::make('password123'),
            'location' => 'Mojoagung, Jombang'
        ]);

        // 3. Admin Batang
        User::create([
            'name' => 'Admin IT Batang',
            'email' => 'batang@onemed.co.id',
            'password' => Hash::make('password123'),
            'location' => 'Batang, Jawa Tengah'
        ]);
    }
}