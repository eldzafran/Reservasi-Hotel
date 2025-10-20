@extends('layouts.app', ['title' => 'Tambah Kamar'])

@section('content')
<h1 class="text-2xl font-semibold mb-6">Tambah Kamar</h1>

<div class="card p-6">
    <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        <label class="text-sm text-gray-600">Nama
            <input type="text" name="name" value="{{ old('name') }}" class="mt-1 w-full rounded-lg border-gray-200" required>
        </label>

        <label class="text-sm text-gray-600">Tipe
            <select name="type" class="mt-1 w-full rounded-lg border-gray-200" required>
                @foreach (['standard','deluxe','suite'] as $t)
                    <option value="{{ $t }}" @selected(old('type')==$t)>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </label>

        <label class="text-sm text-gray-600">Kapasitas
            <input type="number" name="capacity" value="{{ old('capacity',1) }}" min="1" class="mt-1 w-full rounded-lg border-gray-200" required>
        </label>

        <label class="text-sm text-gray-600">Harga / Malam
            <input type="number" name="price_per_night" value="{{ old('price_per_night') }}" min="0" class="mt-1 w-full rounded-lg border-gray-200" required>
        </label>

        <label class="text-sm text-gray-600 md:col-span-2">Deskripsi
            <textarea name="description" rows="4" class="mt-1 w-full rounded-lg border-gray-200">{{ old('description') }}</textarea>
        </label>

        <label class="text-sm text-gray-600">Status
            <select name="status" class="mt-1 w-full rounded-lg border-gray-200" required>
                @foreach (['available','maintenance'] as $s)
                    <option value="{{ $s }}" @selected(old('status',$s)=='available' && $s=='available')>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </label>

        <label class="text-sm text-gray-600">Gambar (opsional)
            <input type="file" name="image" class="mt-1 w-full rounded-lg border-gray-200">
        </label>

        <div class="md:col-span-2 mt-2">
            <button class="btn-primary">Simpan</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn-ghost">Batal</a>
        </div>
    </form>
</div>
@endsection
