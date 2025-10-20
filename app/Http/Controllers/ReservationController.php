<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    // Buat reservasi (user login)
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'   => ['required', 'exists:rooms,id'],
            'check_in'  => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests'    => ['required', 'integer', 'min:1'],
        ]);

        $room = Room::findOrFail($data['room_id']);

        // Tolak bila kamar maintenance
        if ($room->status === 'maintenance') {
            return back()->withErrors(['room_id' => 'Kamar sedang maintenance, silakan pilih kamar lain.'])->withInput();
        }

        $checkIn  = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        $nights   = $checkIn->diffInDays($checkOut);
        if ($nights <= 0) {
            return back()->withErrors(['check_out' => 'Masa inap minimal 1 malam.'])->withInput();
        }

        if ((int)$data['guests'] > (int)$room->capacity) {
            return back()->withErrors(['guests' => 'Jumlah tamu melebihi kapasitas kamar ('.$room->capacity.').'])->withInput();
        }

        // Cegah tanggal bentrok dengan pending/confirmed
        $hasConflict = Reservation::hasConflict(
            roomId: $room->id,
            startDate: $checkIn->toDateString(),
            endDate: $checkOut->toDateString(),
            considerStatuses: ['confirmed','pending']
        );
        if ($hasConflict) {
            return back()->withErrors(['room_id' => 'Tanggal tersebut tidak tersedia untuk kamar ini.'])->withInput();
        }

        $total = $nights * (float)$room->price_per_night;

        Reservation::create([
            'user_id'     => $request->user()->id,
            'room_id'     => $room->id,
            'check_in'    => $checkIn->toDateString(),
            'check_out'   => $checkOut->toDateString(),
            'guests'      => (int)$data['guests'],
            'total_price' => $total,
            'status'      => 'pending',
        ]);

        return redirect()->route('reservations.mine')->with('success', 'Reservasi dibuat dan menunggu konfirmasi.');
    }

    // Daftar reservasi milik user
    public function myReservations(Request $request)
    {
        $reservations = Reservation::with('room')
            ->where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->paginate(10);

        return view('reservations.mine', compact('reservations'));
    }

    // User membatalkan reservasinya
    public function cancel(Request $request, Reservation $reservation)
    {
        if ($reservation->user_id !== $request->user()->id) {
            abort(403);
        }
        if (Carbon::today()->gte($reservation->check_in)) {
            return back()->withErrors(['status' => 'Tidak dapat dibatalkan pada/ setelah tanggal check-in.']);
        }
        if ($reservation->status !== 'cancelled') {
            $reservation->update(['status' => 'cancelled']);
        }
        return back()->with('success', 'Reservasi dibatalkan.');
    }
}
