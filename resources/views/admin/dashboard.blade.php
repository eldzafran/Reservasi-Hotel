<x-app-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
            <a href="{{ route('admin.rooms.create') }}" class="px-4 py-2 rounded bg-emerald-600 text-white">Tambah Kamar</a>
        </div>

        <div class="grid md:grid-cols-4 gap-4 mb-6">
            <div class="border rounded p-4">
                <p class="text-gray-600">Total Kamar</p>
                <p class="text-2xl font-bold">{{ $stats['rooms'] }}</p>
            </div>
            <div class="border rounded p-4">
                <p class="text-gray-600">Total User</p>
                <p class="text-2xl font-bold">{{ $stats['users'] }}</p>
            </div>
            <div class="border rounded p-4 md:col-span-2">
                <p class="text-gray-600">Reservasi</p>
                <p class="text-2xl font-bold">{{ $stats['reservations_total'] }}</p>
                <p class="text-sm text-gray-600">
                    Pending: {{ $stats['reservations_pending'] }} ·
                    Confirmed: {{ $stats['reservations_confirmed'] }} ·
                    Cancelled: {{ $stats['reservations_cancelled'] }}
                </p>
            </div>
        </div>

        <h2 class="font-semibold mb-3">Reservasi Terbaru</h2>
        <div class="overflow-auto">
            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">User</th>
                        <th class="p-2 border">Kamar</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestReservations as $rv)
                        <tr>
                            <td class="p-2 border">{{ $rv->created_at->format('d-m-Y H:i') }}</td>
                            <td class="p-2 border">{{ $rv->user->name }}</td>
                            <td class="p-2 border">{{ $rv->room->name }}</td>
                            <td class="p-2 border capitalize">{{ $rv->status }}</td>
                            <td class="p-2 border">Rp {{ number_format($rv->total_price,0,',','.') }}</td>
                        </tr>
                    @empty
                        <tr><td class="p-3 border text-center" colspan="5">Belum ada reservasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
