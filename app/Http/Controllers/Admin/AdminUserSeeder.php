<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@elhotel.test'],
            [
                'name'     => 'Admin ElHotel',
                'password' => 'password123', // otomatis di-hash via casts 'hashed'
                'role'     => 'admin',
            ]
        );
    }
}
