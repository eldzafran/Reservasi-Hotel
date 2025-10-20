<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationAdminController extends Controller
{
    /**
     * List semua reservasi dengan filter sederhana.
     */
    public function index(Request $request)
    {
        $reservations = Reservation::with(['user','room'])
            ->when($request->filled('status'), fn($q) => $q->where('status', $request->string('status')))
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = $request->string('q');
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$term}%"))
                  ->orWhereHas('room', fn($r) => $r->where('name', 'like', "%{$term}%"));
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.reservations.index', compact('reservations'));
    }

    /**
     * Detail satu reservasi.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load(['user','room']);
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Konfirmasi reservasi (hindari bentrok dengan confirmed lain).
     */
    public function confirm(Reservation $reservation)
    {
        if ($reservation->status === 'cancelled') {
            return back()->withErrors(['status' => 'Reservasi yang dibatalkan tidak dapat dikonfirmasi.']);
        }

        $hasConflict = Reservation::where('room_id', $reservation->room_id)
            ->where('status', 'confirmed')
            ->where('id', '!=', $reservation->id)
            ->where(function ($q) use ($reservation) {
                $q->whereBetween('check_in', [$reservation->check_in, $reservation->check_out])
                  ->orWhereBetween('check_out', [$reservation->check_in, $reservation->check_out])
                  ->orWhere(function ($q2) use ($reservation) {
                      $q2->where('check_in', '<=', $reservation->check_in)
                         ->where('check_out', '>=', $reservation->check_out);
                  });
            })
            ->exists();

        if ($hasConflict) {
            return back()->withErrors(['status' => 'Tanggal bertabrakan dengan reservasi lain yang sudah dikonfirmasi.']);
        }

        $reservation->update(['status' => 'confirmed']);

        return back()->with('success', 'Reservasi dikonfirmasi.');
    }

    /**
     * Batalkan reservasi.
     */
    public function cancel(Reservation $reservation)
    {
        $reservation->update(['status' => 'cancelled']);
        return back()->with('success', 'Reservasi dibatalkan.');
    }

    /**
     * Hapus reservasi.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('admin.reservations.index')->with('success', 'Reservasi dihapus.');
    }
}
