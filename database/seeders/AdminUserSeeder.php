<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Catatan: di User model kita sudah pakai casts 'password' => 'hashed'
        // sehingga string akan otomatis di-hash saat disimpan.
        User::firstOrCreate(
            ['email' => 'admin@elhotel.test'],
            [
                'name'     => 'Admin ElHotel',
                'password' => 'password123',
                'role'     => 'admin',
            ]
        );
    }
}
