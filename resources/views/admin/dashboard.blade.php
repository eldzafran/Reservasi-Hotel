@extends('layouts.app', ['title' => 'Admin Dashboard'])

@section('content')
    {{-- Header + Quick Actions --}}
    <div class="mb-6 flex items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
            <p class="text-gray-600 text-sm">Ringkasan dan aksi cepat untuk pengelolaan.</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.rooms.create') }}" class="btn-primary">+ Tambah Kamar</a>
            <a href="{{ route('admin.rooms.index') }}" class="btn-ghost">Kelola Kamar</a>
            <a href="{{ route('admin.reservations.index') }}" class="btn-ghost">Kelola Reservasi</a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6">
            <p class="text-sm text-gray-500">Total Kamar</p>
            <p class="text-3xl font-semibold mt-1">{{ \App\Models\Room::count() }}</p>
            <a href="{{ route('admin.rooms.index') }}" class="btn-ghost mt-4">Kelola</a>
        </div>
        <div class="card p-6">
            <p class="text-sm text-gray-500">Reservasi Pending</p>
            <p class="text-3xl font-semibold mt-1">{{ \App\Models\Reservation::where('status','pending')->count() }}</p>
            <a href="{{ route('admin.reservations.index', ['status' => 'pending']) }}" class="btn-ghost mt-4">Tinjau</a>
        </div>
        <div class="card p-6">
            <p class="text-sm text-gray-500">Reservasi Terkonfirmasi</p>
            <p class="text-3xl font-semibold mt-1">{{ \App\Models\Reservation::where('status','confirmed')->count() }}</p>
            <a href="{{ route('admin.reservations.index', ['status' => 'confirmed']) }}" class="btn-ghost mt-4">Lihat</a>
        </div>
    </div>

    {{-- Latest Reservations --}}
    <div class="card overflow-hidden mb-8">
        <div class="px-5 py-4 flex items-center justify-between">
            <h2 class="font-semibold">Reservasi Terbaru</h2>
            <a href="{{ route('admin.reservations.index') }}" class="btn-ghost">Lihat Semua</a>
        </div>
        <div class="overflow-auto">
            @php
                $latestReservations = \App\Models\Reservation::with(['user','room'])
                    ->orderByDesc('id')->limit(10)->get();
            @endphp
            <table class="min-w-full">
                <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-5 py-3 text-sm text-gray-600">User</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Kamar</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Check-in</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Check-out</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Status</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Aksi</th>
                </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($latestReservations as $r)
                    <tr>
                        <td class="px-5 py-3">{{ $r->user->name }}</td>
                        <td class="px-5 py-3">{{ $r->room->name }}</td>
                        <td class="px-5 py-3">{{ $r->check_in->format('d-m-Y') }}</td>
                        <td class="px-5 py-3">{{ $r->check_out->format('d-m-Y') }}</td>
                        <td class="px-5 py-3 capitalize">{{ $r->status }}</td>
                        <td class="px-5 py-3 flex flex-wrap gap-2">
                            <a href="{{ route('admin.reservations.show',$r) }}" class="btn-ghost">Detail</a>
                            @if($r->status!=='confirmed')
                                <form action="{{ route('admin.reservations.confirm',$r) }}" method="POST"
                                      onsubmit="return confirm('Konfirmasi reservasi ini?');">
                                    @csrf @method('PATCH')
                                    <button class="btn bg-emerald-600 text-white hover:bg-emerald-700">Confirm</button>
                                </form>
                            @endif
                            @if($r->status!=='cancelled')
                                <form action="{{ route('admin.reservations.cancel',$r) }}" method="POST"
                                      onsubmit="return confirm('Batalkan reservasi ini?');">
                                    @csrf @method('PATCH')
                                    <button class="btn bg-orange-600 text-white hover:bg-orange-700">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-gray-500" colspan="6">Belum ada data.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Quick list kamar + tombol edit/hapus --}}
    @php
        $latestRooms = \App\Models\Room::orderByDesc('id')->limit(8)->get();
    @endphp
    <div class="card overflow-hidden">
        <div class="px-5 py-4 flex items-center justify-between">
            <h2 class="font-semibold">Kamar Terbaru</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.rooms.create') }}" class="btn-primary">+ Tambah Kamar</a>
                <a href="{{ route('admin.rooms.index') }}" class="btn-ghost">Kelola Semua</a>
            </div>
        </div>
        <div class="overflow-auto">
            <table class="min-w-full">
                <thead>
                <tr class="bg-gray-50 text-left">
                    <th class="px-5 py-3 text-sm text-gray-600">Nama</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Tipe</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Kapasitas</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Harga</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Status</th>
                    <th class="px-5 py-3 text-sm text-gray-600">Aksi</th>
                </tr>
                </thead>
                <tbody class="divide-y">
                @forelse($latestRooms as $room)
                    <tr>
                        <td class="px-5 py-3">{{ $room->name }}</td>
                        <td class="px-5 py-3 capitalize">{{ $room->type }}</td>
                        <td class="px-5 py-3">{{ $room->capacity }}</td>
                        <td class="px-5 py-3">Rp {{ number_format($room->price_per_night,0,',','.') }}</td>
                        <td class="px-5 py-3 capitalize">{{ $room->status }}</td>
                        <td class="px-5 py-3 flex gap-2">
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn-ghost">Edit</a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
                                  onsubmit="return confirm('Hapus kamar ini?');">
                                @csrf @method('DELETE')
                                <button class="btn bg-red-600 text-white hover:bg-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="px-5 py-4 text-gray-500" colspan="6">Belum ada kamar.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
