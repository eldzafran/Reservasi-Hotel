<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Reservasi Saya</h1>

        @if (session('success'))
            <div class="p-3 mb-4 bg-green-100 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="p-3 mb-4 bg-red-100 border border-red-300 rounded">
                <ul class="list-disc ms-6">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
            </div>
        @endif

        @if ($reservations->count() === 0)
            <p>Belum ada reservasi.</p>
        @else
            <div class="overflow-auto">
                <table class="min-w-full border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Kamar</th>
                            <th class="p-2 border">Check-in</th>
                            <th class="p-2 border">Check-out</th>
                            <th class="p-2 border">Tamu</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Total</th>
                            <th class="p-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reservations as $r)
                            <tr>
                                <td class="p-2 border">{{ $r->room->name }}</td>
                                <td class="p-2 border">{{ $r->check_in->format('d-m-Y') }}</td>
                                <td class="p-2 border">{{ $r->check_out->format('d-m-Y') }}</td>
                                <td class="p-2 border">{{ $r->guests }}</td>
                                <td class="p-2 border capitalize">{{ $r->status }}</td>
                                <td class="p-2 border">Rp {{ number_format($r->total_price,0,',','.') }}</td>
                                <td class="p-2 border">
                                    @if($r->status !== 'cancelled' && \Illuminate\Support\Carbon::today()->lt($r->check_in))
                                        <form action="{{ route('reservations.cancel',$r) }}" method="POST"
                                              onsubmit="return confirm('Batalkan reservasi ini?');" class="inline-block">
                                            @csrf @method('PATCH')
                                            <button class="px-3 py-1 rounded bg-red-600 text-white">Cancel</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500 text-sm">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $reservations->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
