@extends('layouts.app', ['title' => 'Kelola Kamar'])

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-semibold">Kamar</h1>
        <p class="text-gray-600 text-sm">Tambah, edit, dan hapus kamar.</p>
    </div>
    <a href="{{ route('admin.rooms.create') }}" class="btn-primary">Tambah Kamar</a>
</div>

<div class="card overflow-hidden">
    <div class="px-5 py-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama…" class="border-gray-200 rounded-lg md:col-span-2">
            <select name="type" class="border-gray-200 rounded-lg">
                <option value="">Semua tipe</option>
                @foreach (['standard','deluxe','suite'] as $t)
                    <option value="{{ $t }}" @selected(request('type')==$t)>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
            <button class="btn-ghost md:col-span-1">Filter</button>
        </form>
    </div>

    <div class="overflow-auto">
        <table class="min-w-full">
            <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-5 py-3 text-sm text-gray-600">Nama</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Tipe</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Kapasitas</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Harga/Malam</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Status</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($rooms as $room)
                    <tr>
                        <td class="px-5 py-3">{{ $room->name }}</td>
                        <td class="px-5 py-3 capitalize">{{ $room->type }}</td>
                        <td class="px-5 py-3">{{ $room->capacity }}</td>
                        <td class="px-5 py-3">Rp {{ number_format($room->price_per_night,0,',','.') }}</td>
                        <td class="px-5 py-3 capitalize">{{ $room->status }}</td>
                        <td class="px-5 py-3 flex gap-2">
                            <a href="{{ route('admin.rooms.edit',$room) }}" class="btn-ghost">Edit</a>
                            <form action="{{ route('admin.rooms.destroy',$room) }}" method="POST" onsubmit="return confirm('Hapus kamar ini?');">
                                @csrf @method('DELETE')
                                <button class="btn bg-red-600 text-white hover:bg-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-gray-500" colspan="6">Tidak ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="px-5 py-4 border-t">
        {{ $rooms->withQueryString()->links() }}
    </div>
</div>
@endsection
