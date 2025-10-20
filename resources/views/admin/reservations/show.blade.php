@extends('layouts.app', ['title' => 'Detail Reservasi'])

@section('content')
<h1 class="text-2xl font-semibold mb-6">Detail Reservasi #{{ $reservation->id }}</h1>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="card p-6">
        <h2 class="font-semibold mb-3">Informasi</h2>
        <dl class="grid grid-cols-3 gap-2 text-sm">
            <dt class="text-gray-500">User</dt><dd class="col-span-2">{{ $reservation->user->name }} ({{ $reservation->user->email }})</dd>
            <dt class="text-gray-500">Kamar</dt><dd class="col-span-2">{{ $reservation->room->name }}</dd>
            <dt class="text-gray-500">Check-in</dt><dd class="col-span-2">{{ $reservation->check_in->format('d-m-Y') }}</dd>
            <dt class="text-gray-500">Check-out</dt><dd class="col-span-2">{{ $reservation->check_out->format('d-m-Y') }}</dd>
            <dt class="text-gray-500">Tamu</dt><dd class="col-span-2">{{ $reservation->guests }}</dd>
            <dt class="text-gray-500">Total</dt><dd class="col-span-2">Rp {{ number_format($reservation->total_price,0,',','.') }}</dd>
            <dt class="text-gray-500">Status</dt><dd class="col-span-2 capitalize">{{ $reservation->status }}</dd>
        </dl>
    </div>

    <div class="card p-6">
        <h2 class="font-semibold mb-3">Aksi</h2>
        <div class="flex flex-wrap gap-3">
            @if($reservation->status!=='confirmed')
                <form action="{{ route('admin.reservations.confirm',$reservation) }}" method="POST" onsubmit="return confirm('Konfirmasi reservasi ini?');">
                    @csrf @method('PATCH')
                    <button class="btn bg-emerald-600 text-white hover:bg-emerald-700">Confirm</button>
                </form>
            @endif
            @if($reservation->status!=='cancelled')
                <form action="{{ route('admin.reservations.cancel',$reservation) }}" method="POST" onsubmit="return confirm('Batalkan reservasi ini?');">
                    @csrf @method('PATCH')
                    <button class="btn bg-orange-600 text-white hover:bg-orange-700">Cancel</button>
                </form>
            @endif
            <form action="{{ route('admin.reservations.destroy',$reservation) }}" method="POST" onsubmit="return confirm('Hapus reservasi ini?');">
                @csrf @method('DELETE')
                <button class="btn bg-red-600 text-white hover:bg-red-700">Hapus</button>
            </form>
            <a href="{{ route('admin.reservations.index') }}" class="btn-ghost">Kembali</a>
        </div>
    </div>
</div>
@endsection
