<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat user Admin jika belum ada
        if (!User::where('email', 'admin@hotel.com')->exists()) {
            User::create([
                'name' => 'Hotel Admin',
                'email' => 'admin@hotel.com', // Email untuk login Admin
                'password' => Hash::make('password'), // Password: 'password'
                'role' => 'admin',
            ]);
            $this->command->info('Admin user created: admin@hotel.com (password)');
        }
    }
}