<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Kelola Kamar</h1>
            <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 rounded bg-emerald-600 text-white">Tambah Kamar</a>
        </div>

        <form method="GET" class="flex gap-3 mb-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama..." class="border rounded px-3 py-2">
            <select name="type" class="border rounded px-3 py-2">
                <option value="">Semua Tipe</option>
                @foreach (['standard','deluxe','suite'] as $t)
                    <option value="{{ $t }}" @selected(request('type')==$t)>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 rounded bg-blue-600 text-white">Filter</button>
        </form>

        <div class="overflow-auto">
            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Tipe</th>
                        <th class="p-2 border">Kapasitas</th>
                        <th class="p-2 border">Harga/Malam</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                        <tr>
                            <td class="p-2 border">{{ $room->name }}</td>
                            <td class="p-2 border capitalize">{{ $room->type }}</td>
                            <td class="p-2 border">{{ $room->capacity }}</td>
                            <td class="p-2 border">Rp {{ number_format($room->price_per_night,0,',','.') }}</td>
                            <td class="p-2 border capitalize">{{ $room->status }}</td>
                            <td class="p-2 border">
                                <a href="{{ route('admin.rooms.edit',$room) }}" class="px-3 py-1 rounded bg-yellow-500 text-white">Edit</a>
                                <form action="{{ route('admin.rooms.destroy',$room) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Hapus kamar ini?');">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1 rounded bg-red-600 text-white">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="p-3 border text-center" colspan="6">Belum ada data kamar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $rooms->links() }}
        </div>
    </div>
</x-app-layout>
