<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Reservasi #{{ $reservation->id }}</h1>
            <a href="{{ route('admin.reservations.index') }}" class="px-4 py-2 rounded bg-gray-700 text-white">Kembali</a>
        </div>

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

        <div class="border rounded p-4 space-y-2 mb-4">
            <p><strong>User:</strong> {{ $reservation->user->name }} ({{ $reservation->user->email }})</p>
            <p><strong>Kamar:</strong> {{ $reservation->room->name }} ({{ ucfirst($reservation->room->type) }})</p>
            <p><strong>Periode:</strong> {{ $reservation->check_in->format('d-m-Y') }} → {{ $reservation->check_out->format('d-m-Y') }}</p>
            <p><strong>Tamu:</strong> {{ $reservation->guests }}</p>
            <p><strong>Status:</strong> <span class="capitalize">{{ $reservation->status }}</span></p>
            <p><strong>Total:</strong> Rp {{ number_format($reservation->total_price,0,',','.') }}</p>
            <p><strong>Dibuat:</strong> {{ $reservation->created_at->format('d-m-Y H:i') }}</p>
        </div>

        <div class="flex gap-3">
            @if($reservation->status !== 'confirmed')
                <form action="{{ route('admin.reservations.confirm',$reservation) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="px-4 py-2 rounded bg-emerald-600 text-white"
                        onclick="return confirm('Konfirmasi reservasi ini?')">Konfirmasi</button>
                </form>
            @endif

            @if($reservation->status !== 'cancelled')
                <form action="{{ route('admin.reservations.cancel',$reservation) }}" method="POST">
                    @csrf @method('PATCH')
                    <button class="px-4 py-2 rounded bg-yellow-600 text-white"
                        onclick="return confirm('Batalkan reservasi ini?')">Batalkan</button>
                </form>
            @endif

            <form action="{{ route('admin.reservations.destroy',$reservation) }}" method="POST"
                  onsubmit="return confirm('Hapus reservasi ini?')">
                @csrf @method('DELETE')
                <button class="px-4 py-2 rounded bg-red-600 text-white">Hapus</button>
            </form>
        </div>
    </div>
</x-app-layout>
