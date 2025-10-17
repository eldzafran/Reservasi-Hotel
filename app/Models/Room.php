<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type',
        'star_rating',
        'price_per_night',
        'description',
        'total_available_rooms',
    ];
    
    // Relationship: Satu Kamar bisa memiliki banyak Reservasi
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}