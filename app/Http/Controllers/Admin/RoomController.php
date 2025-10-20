<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * List kamar (admin).
     */
    public function index(Request $request)
    {
        $rooms = Room::query()
            ->when($request->filled('type'), fn($q) => $q->where('type', $request->string('type')))
            ->when($request->filled('q'), fn($q) => $q->where('name', 'like', '%'.$request->input('q').'%'))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.rooms.index', compact('rooms'));
    }

    /**
     * Form tambah kamar.
     */
    public function create()
    {
        $types = ['standard', 'deluxe', 'suite'];
        $statuses = ['available', 'maintenance'];
        return view('admin.rooms.create', compact('types', 'statuses'));
    }

    /**
     * Simpan kamar baru.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'type'            => ['required', 'in:standard,deluxe,suite'],
            'capacity'        => ['required', 'integer', 'min:1'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'description'     => ['nullable', 'string'],
            'status'          => ['required', 'in:available,maintenance'],
            'image'           => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        Room::create([
            'name'            => $data['name'],
            'type'            => $data['type'],
            'capacity'        => (int)$data['capacity'],
            'price_per_night' => (float)$data['price_per_night'],
            'description'     => $data['description'] ?? null,
            'status'          => $data['status'],
            'image_path'      => $imagePath,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil ditambahkan.');
    }

    /**
     * Detail kamar (opsional).
     */
    public function show(Room $room)
    {
        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Form edit.
     */
    public function edit(Room $room)
    {
        $types = ['standard', 'deluxe', 'suite'];
        $statuses = ['available', 'maintenance'];
        return view('admin.rooms.edit', compact('room', 'types', 'statuses'));
    }

    /**
     * Update kamar.
     */
    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'type'            => ['required', 'in:standard,deluxe,suite'],
            'capacity'        => ['required', 'integer', 'min:1'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
            'description'     => ['nullable', 'string'],
            'status'          => ['required', 'in:available,maintenance'],
            'image'           => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $room->image_path = $request->file('image')->store('rooms', 'public');
        }

        $room->fill([
            'name'            => $data['name'],
            'type'            => $data['type'],
            'capacity'        => (int)$data['capacity'],
            'price_per_night' => (float)$data['price_per_night'],
            'description'     => $data['description'] ?? null,
            'status'          => $data['status'],
        ])->save();

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil diperbarui.');
    }

    /**
     * Hapus kamar.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
