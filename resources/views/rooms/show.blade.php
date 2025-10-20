@extends('layouts.app', ['title' => $room->name])

@section('content')
<div class="grid md:grid-cols-2 gap-8">
    <div class="card overflow-hidden">
        @if ($room->image_path)
            <img src="{{ asset('storage/'.$room->image_path) }}" class="w-full h-72 object-cover" alt="">
        @else
            <div class="w-full h-72 bg-gray-100"></div>
        @endif
        <div class="p-6">
            <h1 class="text-2xl font-semibold">{{ $room->name }}</h1>
            <p class="text-gray-600 mt-1">Tipe: {{ ucfirst($room->type) }} · Kapasitas: {{ $room->capacity }}</p>
            <p class="text-primary font-semibold mt-2">Rp {{ number_format($room->price_per_night,0,',','.') }} <span class="font-normal text-gray-500 text-sm">/malam</span></p>
            <p class="mt-4 text-gray-700">{{ $room->description }}</p>
        </div>
    </div>

    <div class="card p-6">
        <h2 class="font-semibold text-lg">Pesan Kamar Ini</h2>
        @if ($room->status === 'maintenance')
            <div class="mt-3 rounded-lg border border-yellow-300 bg-yellow-50 px-4 py-3 text-yellow-800">
                Kamar ini sedang <b>maintenance</b> dan tidak dapat dipesan saat ini.
            </div>
        @endif

        @auth
            <form method="POST" action="{{ route('reservations.store') }}" class="mt-4 grid grid-cols-1 gap-3">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">

                <label class="text-sm text-gray-600">Check-in
                    <input type="date" name="check_in" value="{{ old('check_in') }}" class="mt-1 rounded-lg border-gray-200 w-full" required>
                </label>

                <label class="text-sm text-gray-600">Check-out
                    <input type="date" name="check_out" value="{{ old('check_out') }}" class="mt-1 rounded-lg border-gray-200 w-full" required>
                </label>

                <label class="text-sm text-gray-600">Jumlah Tamu
                    <input type="number" min="1" name="guests" value="{{ old('guests',1) }}" class="mt-1 rounded-lg border-gray-200 w-full" required>
                </label>

                <button class="btn-primary mt-2" @if($room->status==='maintenance') disabled @endif>
                    Buat Reservasi
                </button>
            </form>
        @else
            <p class="mt-4">Silakan <a class="text-primary underline" href="{{ route('login') }}">login</a> untuk memesan.</p>
        @endauth
    </div>
</div>
@endsection
