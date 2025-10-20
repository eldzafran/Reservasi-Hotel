@extends('layouts.app', ['title' => 'Daftar Kamar'])

@section('content')
    <div class="flex items-end justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Daftar Kamar</h1>
            <p class="text-gray-600 text-sm">Filter untuk menemukan kamar yang pas.</p>
        </div>
        <a href="{{ route('reservations.mine') }}" class="btn-ghost">Reservasi Saya</a>
    </div>

    <form method="GET" class="card p-4 md:p-5 mb-6 grid grid-cols-2 md:grid-cols-6 gap-3">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama…" class="border-gray-200 rounded-lg col-span-2 md:col-span-2">
        <select name="type" class="border-gray-200 rounded-lg">
            <option value="">Tipe</option>
            @foreach (['standard','deluxe','suite'] as $t)
                <option value="{{ $t }}" @selected(request('type')==$t)>{{ ucfirst($t) }}</option>
            @endforeach
        </select>
        <input type="number" name="capacity" value="{{ request('capacity') }}" placeholder="Kapasitas" class="border-gray-200 rounded-lg">
        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Harga" class="border-gray-200 rounded-lg">
        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max Harga" class="border-gray-200 rounded-lg">
        <button class="btn-primary col-span-2 md:col-span-1">Terapkan</button>
    </form>

    @if ($rooms->isEmpty())
        <p class="text-gray-600">Tidak ada kamar ditemukan.</p>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($rooms as $room)
            <div class="card overflow-hidden">
                @if ($room->image_path)
                    <img src="{{ asset('storage/'.$room->image_path) }}" alt="{{ $room->name }}" class="h-44 w-full object-cover">
                @else
                    <div class="h-44 w-full bg-gray-100"></div>
                @endif

                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-lg">{{ $room->name }}</h3>
                        <span class="text-sm text-gray-500 capitalize">{{ $room->type }}</span>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Kapasitas {{ $room->capacity }} orang</p>
                    <p class="mt-2 font-semibold text-primary">Rp {{ number_format($room->price_per_night,0,',','.') }} <span class="font-normal text-gray-500 text-sm">/malam</span></p>

                    <div class="mt-4 flex items-center justify-between">
                        <a href="{{ route('rooms.show',$room) }}" class="btn-ghost">Detail</a>
                        @if($room->status === 'available')
                            <span class="badge badge-green">Tersedia</span>
                        @else
                            <span class="badge badge-yellow">Maintenance</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $rooms->withQueryString()->links() }}
    </div>
@endsection
