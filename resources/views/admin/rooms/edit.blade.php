<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Edit Kamar</h1>

        @if ($errors->any())
            <div class="p-3 mb-4 bg-red-100 border border-red-300 rounded">
                <ul class="list-disc ms-6">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.rooms.update',$room) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')

            <div>
                <label class="block text-sm mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name',$room->name) }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm mb-1">Tipe</label>
                    <select name="type" class="w-full border rounded px-3 py-2" required>
                        @foreach (['standard','deluxe','suite'] as $t)
                            <option value="{{ $t }}" @selected(old('type',$room->type)==$t)>{{ ucfirst($t) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm mb-1">Kapasitas</label>
                    <input type="number" name="capacity" min="1" value="{{ old('capacity',$room->capacity) }}" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm mb-1">Harga per Malam</label>
                    <input type="number" name="price_per_night" min="0" value="{{ old('price_per_night',$room->price_per_night) }}" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div>
                <label class="block text-sm mb-1">Status</label>
                <select name="status" class="w-full border rounded px-3 py-2" required>
                    @foreach (['available','maintenance'] as $s)
                        <option value="{{ $s }}" @selected(old('status',$room->status)==$s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm mb-1">Deskripsi</label>
                <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description',$room->description) }}</textarea>
            </div>

            <div>
                <label class="block text-sm mb-1">Gambar (opsional)</label>
                <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
                @if($room->image_path)
                    <img src="{{ asset('storage/'.$room->image_path) }}" alt="{{ $room->name }}" class="mt-2 w-40 h-28 object-cover rounded">
                @endif
            </div>

            <div class="flex gap-3">
                <button class="px-4 py-2 rounded bg-emerald-600 text-white">Update</button>
                <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 rounded bg-gray-600 text-white">Kembali</a>
            </div>
        </form>
    </div>
</x-app-layout>
