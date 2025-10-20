<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    /**
     * Mass assignable.
     */
    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status',
    ];

    /**
     * Casts untuk tanggal & numeric.
     */
    protected $casts = [
        'check_in'    => 'date',
        'check_out'   => 'date',
        'guests'      => 'integer',
        'total_price' => 'decimal:2',
    ];

    /**
     * Relasi ke user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke room.
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Scope untuk status tertentu (misal: confirmed).
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Helper: cek apakah periode reservasi ini bertabrakan
     * dengan periode [start, end] (inklusif) pada kamar yang sama,
     * untuk status tertentu (default: confirmed).
     */
    public static function hasConflict(
        int $roomId,
        string $startDate, // 'Y-m-d'
        string $endDate,   // 'Y-m-d'
        array $considerStatuses = ['confirmed']
    ): bool {
        return static::where('room_id', $roomId)
            ->whereIn('status', $considerStatuses)
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('check_in', [$startDate, $endDate])
                  ->orWhereBetween('check_out', [$startDate, $endDate])
                  ->orWhere(function ($q2) use ($startDate, $endDate) {
                      $q2->where('check_in', '<=', $startDate)
                         ->where('check_out', '>=', $endDate);
                  });
            })
            ->exists();
    }
}
