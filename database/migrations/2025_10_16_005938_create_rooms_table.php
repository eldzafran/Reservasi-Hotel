<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_type');         // Contoh: Standard, Deluxe, Suite
            $table->integer('star_rating');      // Kualitas bintang: 1, 3, 5, dll.
            $table->decimal('price_per_night', 8, 2);
            $table->text('description')->nullable();
            $table->integer('total_available_rooms'); // Jumlah total kamar tipe ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};