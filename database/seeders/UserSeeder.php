<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'admin@codecraftstudio.com',
            'username' => 'admin',
            'full_name' => 'Alex Johnson',
            'password' => Hash::make('Admin123!'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'email' => 'dev@codecraftstudio.com',
            'username' => 'developer',
            'full_name' => 'Sam Wilson',
            'password' => Hash::make('Developer123!'),
            'role' => 'developer',
            'is_active' => true,
        ]);

        User::factory()->count(3)->create();
    }
}