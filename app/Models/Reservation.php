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
        'check_in',
        'check_out',
        'guests',
        'total_price',
        'status', // pending | confirmed | cancelled
    ];

    protected $casts = [
        'check_in'   => 'date',
        'check_out'  => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Cek konflik tanggal menggunakan aturan interval [start, end):
     * overlap jika (existing.start < new.end) && (existing.end > new.start)
     *
     * @param int    $roomId
     * @param string $startDate  format YYYY-MM-DD
     * @param string $endDate    format YYYY-MM-DD
     * @param array  $considerStatuses default ['confirmed']
     */
    public static function hasConflict(
        int $roomId,
        string $startDate,
        string $endDate,
        array $considerStatuses = ['confirmed']
    ): bool {
        return static::where('room_id', $roomId)
            ->whereIn('status', $considerStatuses)
            ->where(function ($q) use ($startDate, $endDate) {
                $q->where('check_in', '<', $endDate)    // existing.start < new.end
                  ->where('check_out', '>', $startDate); // existing.end   > new.start
            })
            ->exists();
    }
}
