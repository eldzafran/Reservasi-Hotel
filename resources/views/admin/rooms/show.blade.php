<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">{{ $room->name }}</h1>

        @if($room->image_path)
            <img src="{{ asset('storage/'.$room->image_path) }}" alt="{{ $room->name }}" class="w-full h-64 object-cover rounded mb-4">
        @endif

        <ul class="space-y-1 mb-4">
            <li><strong>Tipe:</strong> {{ ucfirst($room->type) }}</li>
            <li><strong>Kapasitas:</strong> {{ $room->capacity }}</li>
            <li><strong>Status:</strong> {{ ucfirst($room->status) }}</li>
            <li><strong>Harga/Malam:</strong> Rp {{ number_format($room->price_per_night,0,',','.') }}</li>
        </ul>

        <p>{{ $room->description }}</p>

        <div class="mt-4 flex gap-3">
            <a href="{{ route('admin.rooms.edit',$room) }}" class="px-4 py-2 rounded bg-yellow-500 text-white">Edit</a>
            <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 rounded bg-gray-600 text-white">Kembali</a>
        </div>
    </div>
</x-app-layout>
