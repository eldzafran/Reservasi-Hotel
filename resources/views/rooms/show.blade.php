<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <div class="grid md:grid-cols-2 gap-6">
            <div>
                @if ($room->image_path)
                    <img src="{{ asset('storage/'.$room->image_path) }}" alt="{{ $room->name }}" class="w-full h-64 object-cover rounded mb-3">
                @endif
                <h1 class="text-2xl font-semibold mb-2">{{ $room->name }}</h1>
                <p class="text-gray-600 mb-1">Tipe: {{ ucfirst($room->type) }}</p>
                <p class="text-gray-600 mb-1">Kapasitas: {{ $room->capacity }}</p>
                <p class="text-gray-800 mb-3">Harga/malam: Rp {{ number_format($room->price_per_night,0,',','.') }}</p>
                <p class="mb-3">{{ $room->description }}</p>
            </div>

            <div class="border rounded p-4">
                <h2 class="font-semibold mb-3">Pesan Kamar Ini</h2>

                @if ($room->status === 'maintenance')
                    <div class="p-3 mb-3 bg-yellow-100 border border-yellow-300 rounded">
                        Kamar ini sedang <strong>maintenance</strong> dan tidak dapat dipesan saat ini.
                    </div>
                @endif

                @auth
                    @if($errors->any())
                        <div class="p-3 mb-3 bg-red-100 border border-red-300 rounded">
                            <ul class="list-disc ms-6">
                                @foreach($errors->all() as $e)
                                    <li>{{ $e }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('reservations.store') }}" class="space-y-3">
                        @csrf
                        <input type="hidden" name="room_id" value="{{ $room->id }}">

                        <div>
                            <label class="block text-sm mb-1">Check-in</label>
                            <input type="date" name="check_in" value="{{ old('check_in') }}" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Check-out</label>
                            <input type="date" name="check_out" value="{{ old('check_out') }}" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <div>
                            <label class="block text-sm mb-1">Jumlah Tamu</label>
                            <input type="number" name="guests" min="1" value="{{ old('guests',1) }}" class="w-full border rounded px-3 py-2" required>
                        </div>

                        <button class="px-4 py-2 rounded bg-emerald-600 text-white"
                                @if($room->status==='maintenance') disabled @endif>
                            Buat Reservasi
                        </button>
                    </form>
                @else
                    <p>Silakan <a class="text-blue-600 underline" href="{{ route('login') }}">login</a> untuk memesan.</p>
                @endauth
            </div>
        </div>
    </div>
</x-app-layout>
