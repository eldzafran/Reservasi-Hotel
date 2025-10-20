<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Tampilkan ringkasan data untuk admin.
     */
    public function index()
    {
        $stats = [
            'rooms'                  => Room::count(),
            'users'                  => User::where('role', 'user')->count(),
            'reservations_total'     => Reservation::count(),
            'reservations_pending'   => Reservation::where('status', 'pending')->count(),
            'reservations_confirmed' => Reservation::where('status', 'confirmed')->count(),
            'reservations_cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        $latestReservations = Reservation::with(['user', 'room'])
            ->orderByDesc('id')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestReservations'));
    }
}
