<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'profile_picture' => null,
            'password' => bcrypt('admin1234'),
        ]);

        // Create Regular User
        User::create([
            'name' => 'Regular',
            'email' => 'user@example.com',
            'role' => 'user',
            'profile_picture' => null,
            'password' => bcrypt('user1234'),
        ]);

    }
}
