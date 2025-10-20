@extends('layouts.app', ['title' => 'Kelola Reservasi'])

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-semibold">Reservasi</h1>
    <p class="text-gray-600 text-sm">Konfirmasi / batalkan reservasi yang masuk.</p>
</div>

<div class="card overflow-hidden">
    <div class="px-5 py-4">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-3">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari user / kamar" class="border-gray-200 rounded-lg md:col-span-2">
            <select name="status" class="border-gray-200 rounded-lg">
                <option value="">Semua status</option>
                @foreach(['pending','confirmed','cancelled'] as $st)
                    <option value="{{ $st }}" @selected(request('status')==$st)>{{ ucfirst($st) }}</option>
                @endforeach
            </select>
            <button class="btn-ghost">Filter</button>
        </form>
    </div>

    <div class="overflow-auto">
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
                @foreach($reservations as $r)
                    <tr>
                        <td class="px-5 py-3">{{ $r->user->name }}</td>
                        <td class="px-5 py-3">{{ $r->room->name }}</td>
                        <td class="px-5 py-3">{{ $r->check_in->format('d-m-Y') }}</td>
                        <td class="px-5 py-3">{{ $r->check_out->format('d-m-Y') }}</td>
                        <td class="px-5 py-3 capitalize">{{ $r->status }}</td>
                        <td class="px-5 py-3 flex flex-wrap gap-2">
                            <a href="{{ route('admin.reservations.show',$r) }}" class="btn-ghost">Detail</a>

                            @if($r->status!=='confirmed')
                                <form action="{{ route('admin.reservations.confirm',$r) }}" method="POST" onsubmit="return confirm('Konfirmasi reservasi ini?');">
                                    @csrf @method('PATCH')
                                    <button class="btn bg-emerald-600 text-white hover:bg-emerald-700">Confirm</button>
                                </form>
                            @endif

                            @if($r->status!=='cancelled')
                                <form action="{{ route('admin.reservations.cancel',$r) }}" method="POST" onsubmit="return confirm('Batalkan reservasi ini?');">
                                    @csrf @method('PATCH')
                                    <button class="btn bg-orange-600 text-white hover:bg-orange-700">Cancel</button>
                                </form>
                            @endif

                            <form action="{{ route('admin.reservations.destroy',$r) }}" method="POST" onsubmit="return confirm('Hapus reservasi ini?');">
                                @csrf @method('DELETE')
                                <button class="btn bg-red-600 text-white hover:bg-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                @if($reservations->count()===0)
                    <tr><td class="px-5 py-4 text-gray-500" colspan="6">Tidak ada data.</td></tr>
                @endif
            </tbody>
        </table>
    </div>
    <div class="px-5 py-4 border-t">
        {{ $reservations->withQueryString()->links() }}
    </div>
</div>
@endsection
