<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'number_of_rooms',
        'total_price',
        'status',
    ];

    // Relationship: Reservasi milik satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: Reservasi untuk satu Tipe Kamar
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}