<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    /**
     * Mass assignable.
     */
    protected $fillable = [
        'name',
        'type',
        'capacity',
        'price_per_night',
        'description',
        'status',
        'image_path',
    ];

    /**
     * Casts untuk membantu penanganan data.
     */
    protected $casts = [
        'capacity' => 'integer',
        'price_per_night' => 'decimal:2',
    ];

    /**
     * Relasi: satu room punya banyak reservations.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Scope sederhana untuk hanya kamar yang tersedia.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
