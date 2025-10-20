<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Tampilkan daftar kamar (dengan filter opsional).
     * Query params:
     * - type: standard|deluxe|suite
     * - min_price, max_price: angka
     * - capacity: minimal kapasitas
     * - q: cari nama kamar
     */
    public function index(Request $request)
    {
        $rooms = Room::query()
            ->when($request->filled('type'), fn($q) => $q->where('type', $request->string('type')))
            ->when($request->filled('min_price'), fn($q) => $q->where('price_per_night', '>=', (float) $request->input('min_price')))
            ->when($request->filled('max_price'), fn($q) => $q->where('price_per_night', '<=', (float) $request->input('max_price')))
            ->when($request->filled('capacity'), fn($q) => $q->where('capacity', '>=', (int) $request->input('capacity')))
            ->when($request->filled('q'), fn($q) => $q->where('name', 'like', '%'.$request->input('q').'%'))
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Detail kamar.
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }
}
