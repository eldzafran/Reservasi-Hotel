@extends('layouts.app', ['title' => 'Reservasi Saya'])

@section('content')
<h1 class="text-2xl font-semibold mb-6">Reservasi Saya</h1>

@if ($reservations->count() === 0)
    <div class="card p-6">
        <p class="text-gray-600">Belum ada reservasi. <a class="text-primary underline" href="{{ route('rooms.index') }}">Cari kamar</a>.</p>
    </div>
@else
    <div class="card overflow-hidden">
        <div class="overflow-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-5 py-3 text-sm font-medium text-gray-600">Kamar</th>
                        <th class="px-5 py-3 text-sm font-medium text-gray-600">Check-in</th>
                        <th class="px-5 py-3 text-sm font-medium text-gray-600">Check-out</th>
                        <th class="px-5 py-3 text-sm font-medium text-gray-600">Tamu</th>
                        <th class="px-5 py-3 text-sm font-medium text-gray-600">Status</th>
                        <th class="px-5 py-3 text-sm font-medium text-gray-600">Total</th>
                        <th class="px-5 py-3 text-sm font-medium text-gray-600">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($reservations as $r)
                        <tr>
                            <td class="px-5 py-4">{{ $r->room->name }}</td>
                            <td class="px-5 py-4">{{ $r->check_in->format('d-m-Y') }}</td>
                            <td class="px-5 py-4">{{ $r->check_out->format('d-m-Y') }}</td>
                            <td class="px-5 py-4">{{ $r->guests }}</td>
                            <td class="px-5 py-4">
                                @php
                                    $map = ['pending'=>'badge-yellow','confirmed'=>'badge-green','cancelled'=>'badge-red'];
                                @endphp
                                <span class="{{ $map[$r->status] ?? 'badge' }}">{{ ucfirst($r->status) }}</span>
                            </td>
                            <td class="px-5 py-4">Rp {{ number_format($r->total_price,0,',','.') }}</td>
                            <td class="px-5 py-4">
                                @if($r->status !== 'cancelled' && \Illuminate\Support\Carbon::today()->lt($r->check_in))
                                    <form action="{{ route('reservations.cancel',$r) }}" method="POST"
                                          onsubmit="return confirm('Batalkan reservasi ini?');" class="inline-block">
                                        @csrf @method('PATCH')
                                        <button class="btn bg-red-600 text-white hover:bg-red-700">Batal</button>
                                    </form>
                                @else
                                    <span class="text-gray-400 text-sm">—</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t">
            {{ $reservations->links() }}
        </div>
    </div>
@endif
@endsection
