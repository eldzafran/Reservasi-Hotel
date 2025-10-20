<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kalau RoomFactory ada, isi contoh kamar
        if (class_exists(\Database\Factories\RoomFactory::class)) {
            Room::factory(12)->create();
        }

        // Panggil seeder admin
        $this->call(AdminUserSeeder::class);
    }
}
