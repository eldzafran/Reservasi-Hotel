<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Daftar Kamar</h1>

        <form method="GET" class="flex flex-wrap gap-3 mb-6">
            <select name="type" class="border rounded px-3 py-2">
                <option value="">Semua Tipe</option>
                @foreach (['standard','deluxe','suite'] as $t)
                    <option value="{{ $t }}" @selected(request('type')==$t)>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
            <input type="number" name="min_price" placeholder="Min Harga" value="{{ request('min_price') }}" class="border rounded px-3 py-2">
            <input type="number" name="max_price" placeholder="Max Harga" value="{{ request('max_price') }}" class="border rounded px-3 py-2">
            <input type="number" name="capacity"  placeholder="Minimal Kapasitas" value="{{ request('capacity') }}" class="border rounded px-3 py-2">
            <input type="text"   name="q"         placeholder="Cari nama kamar..." value="{{ request('q') }}" class="border rounded px-3 py-2">
            <button class="px-4 py-2 rounded bg-blue-600 text-white">Filter</button>
        </form>

        @if ($rooms->isEmpty())
            <p>Tidak ada kamar ditemukan.</p>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($rooms as $room)
                <div class="border rounded-lg p-4">
                    @if ($room->image_path)
                        <img src="{{ asset('storage/'.$room->image_path) }}" alt="{{ $room->name }}" class="w-full h-40 object-cover rounded mb-3">
                    @endif
                    <h3 class="font-semibold text-lg mb-1">{{ $room->name }}</h3>
                    <p class="text-sm text-gray-600 mb-1">Tipe: {{ ucfirst($room->type) }}</p>
                    <p class="text-sm text-gray-600 mb-1">Kapasitas: {{ $room->capacity }}</p>
                    <p class="text-sm text-gray-800 mb-2">Harga/malam: Rp {{ number_format($room->price_per_night,0,',','.') }}</p>
                    <a href="{{ route('rooms.show',$room) }}" class="inline-block px-3 py-2 rounded bg-indigo-600 text-white">Detail</a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $rooms->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
