<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $q    = $request->input('q');
        $type = $request->input('type');

        $rooms = Room::query()
            ->when($q, fn($qb) => $qb->where('name','like',"%{$q}%"))
            ->when($type, fn($qb) => $qb->where('type',$type))
            ->orderByDesc('id')
            ->paginate(15);

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => ['required','string','max:255'],
            'type'            => ['required','in:standard,deluxe,suite'],
            'capacity'        => ['required','integer','min:1'],
            'price_per_night' => ['required','numeric','min:0'],
            'description'     => ['nullable','string'],
            'status'          => ['required','in:available,maintenance'],
            'image'           => ['nullable','image','max:2048'],
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')
                ->store('rooms', 'public'); // simpan di storage/app/public/rooms
        }

        Room::create($data);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success','Kamar berhasil ditambahkan.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'name'            => ['required','string','max:255'],
            'type'            => ['required','in:standard,deluxe,suite'],
            'capacity'        => ['required','integer','min:1'],
            'price_per_night' => ['required','numeric','min:0'],
            'description'     => ['nullable','string'],
            'status'          => ['required','in:available,maintenance'],
            'image'           => ['nullable','image','max:2048'],
        ]);

        if ($request->hasFile('image')) {
            // hapus file lama jika ada
            if ($room->image_path && Storage::disk('public')->exists($room->image_path)) {
                Storage::disk('public')->delete($room->image_path);
            }
            $data['image_path'] = $request->file('image')->store('rooms', 'public');
        }

        $room->update($data);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success','Kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        if ($room->image_path && Storage::disk('public')->exists($room->image_path)) {
            Storage::disk('public')->delete($room->image_path);
        }

        $room->delete();

        return back()->with('success','Kamar berhasil dihapus.');
    }
}
