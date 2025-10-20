<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    /**
     * Buat reservasi baru (user harus login).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'   => ['required', 'exists:rooms,id'],
            'check_in'  => ['required', 'date', 'after_or_equal:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'guests'    => ['required', 'integer', 'min:1'],
        ]);

        $room = Room::findOrFail($data['room_id']);

        // Hitung jumlah malam
        $checkIn  = Carbon::parse($data['check_in']);
        $checkOut = Carbon::parse($data['check_out']);
        $nights   = $checkIn->diffInDays($checkOut);

        if ($nights <= 0) {
            return back()->withErrors(['check_out' => 'Masa inap minimal 1 malam.'])->withInput();
        }

        // Cek kapasitas
        if ((int)$data['guests'] > (int)$room->capacity) {
            return back()->withErrors(['guests' => 'Jumlah tamu melebihi kapasitas kamar ('.$room->capacity.').'])->withInput();
        }

        // Cek bentrok jadwal (status confirmed)
        $hasConflict = Reservation::hasConflict(
            roomId: $room->id,
            startDate: $checkIn->toDateString(),
            endDate: $checkOut->toDateString(),
            considerStatuses: ['confirmed']
        );

        if ($hasConflict) {
            return back()->withErrors(['room_id' => 'Tanggal tersebut sudah terisi untuk kamar ini.'])->withInput();
        }

        // Hitung total harga
        $total = $nights * (float)$room->price_per_night;

        Reservation::create([
            'user_id'     => $request->user()->id,
            'room_id'     => $room->id,
            'check_in'    => $checkIn->toDateString(),
            'check_out'   => $checkOut->toDateString(),
            'guests'      => (int)$data['guests'],
            'total_price' => $total,
            'status'      => 'pending', // admin akan mengkonfirmasi
        ]);

        return redirect()->route('reservations.mine')->with('success', 'Reservasi dibuat dan menunggu konfirmasi.');
    }

    /**
     * Daftar reservasi milik user login.
     */
    public function myReservations(Request $request)
    {
        $reservations = Reservation::with('room')
            ->where('user_id', $request->user()->id)
            ->orderByDesc('id')
            ->paginate(10);

        return view('reservations.mine', compact('reservations'));
    }
}
