<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Buat tabel reservations untuk penyimpanan data pemesanan kamar.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            // Relasi
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();

            // Periode menginap
            $table->date('check_in')->index();
            $table->date('check_out')->index();

            // Detail pemesanan
            $table->unsignedInteger('guests')->default(1);
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending')->index();

            $table->timestamps();

            // Index gabungan untuk mempercepat pengecekan bentrok jadwal
            $table->index(['room_id', 'status', 'check_in', 'check_out'], 'room_status_dates_idx');
        });
    }

    /**
     * Drop tabel reservations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
