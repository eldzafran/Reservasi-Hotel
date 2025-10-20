<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel rooms untuk data kamar.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();

            // Info dasar kamar
            $table->string('name'); // contoh: "Deluxe 101"
            $table->enum('type', ['standard', 'deluxe', 'suite'])->index(); // kualitas/tipe
            $table->unsignedInteger('capacity')->default(2);
            $table->decimal('price_per_night', 10, 2);
            $table->text('description')->nullable();

            // Status ketersediaan
            $table->enum('status', ['available', 'maintenance'])->default('available')->index();

            // (Opsional) gambar utama kamar
            $table->string('image_path')->nullable();

            $table->timestamps();

            // Index tambahan yang membantu pencarian
            $table->index(['type', 'status']);
        });
    }

    /**
     * Drop tabel rooms.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
