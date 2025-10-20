<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Daftar kamar dengan filter sederhana
    public function index(Request $request)
    {
        $rooms = Room::query()
            ->when($request->filled('type'), fn($q) => $q->where('type', $request->string('type')))
            ->when($request->filled('min_price'), fn($q) => $q->where('price_per_night', '>=', (float)$request->min_price))
            ->when($request->filled('max_price'), fn($q) => $q->where('price_per_night', '<=', (float)$request->max_price))
            ->when($request->filled('capacity'), fn($q) => $q->where('capacity', '>=', (int)$request->capacity))
            ->when($request->filled('q'), fn($q) => $q->where('name', 'like', '%'.$request->q.'%'))
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('rooms.index', compact('rooms'));
    }

    // Detail kamar + form pesan ada di view
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }
}
