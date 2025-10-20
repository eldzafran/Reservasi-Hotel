<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold">Reservasi</h1>
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded bg-gray-700 text-white">Kembali ke Dashboard</a>
        </div>

        <form method="GET" class="flex flex-wrap gap-3 mb-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari user/kamar..." class="border rounded px-3 py-2">
            <select name="status" class="border rounded px-3 py-2">
                <option value="">Semua Status</option>
                @foreach (['pending','confirmed','cancelled'] as $s)
                    <option value="{{ $s }}" @selected(request('status')==$s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 rounded bg-blue-600 text-white">Filter</button>
        </form>

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

        <div class="overflow-auto">
            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-2 border">ID</th>
                        <th class="p-2 border">User</th>
                        <th class="p-2 border">Kamar</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Tamu</th>
                        <th class="p-2 border">Total</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $r)
                        <tr>
                            <td class="p-2 border">#{{ $r->id }}</td>
                            <td class="p-2 border">{{ $r->user->name }}</td>
                            <td class="p-2 border">{{ $r->room->name }}</td>
                            <td class="p-2 border">
                                {{ $r->check_in->format('d-m-Y') }} → {{ $r->check_out->format('d-m-Y') }}
                            </td>
                            <td class="p-2 border">{{ $r->guests }}</td>
                            <td class="p-2 border">Rp {{ number_format($r->total_price,0,',','.') }}</td>
                            <td class="p-2 border capitalize">{{ $r->status }}</td>
                            <td class="p-2 border">
                                <a href="{{ route('admin.reservations.show',$r) }}" class="px-3 py-1 rounded bg-indigo-600 text-white">Detail</a>

                                @if($r->status !== 'confirmed')
                                    <form action="{{ route('admin.reservations.confirm',$r) }}" method="POST" class="inline-block">
                                        @csrf @method('PATCH')
                                        <button class="px-3 py-1 rounded bg-emerald-600 text-white"
                                            onclick="return confirm('Konfirmasi reservasi #{{ $r->id }} ?')">Confirm</button>
                                    </form>
                                @endif

                                @if($r->status !== 'cancelled')
                                    <form action="{{ route('admin.reservations.cancel',$r) }}" method="POST" class="inline-block">
                                        @csrf @method('PATCH')
                                        <button class="px-3 py-1 rounded bg-yellow-600 text-white"
                                            onclick="return confirm('Batalkan reservasi #{{ $r->id }} ?')">Cancel</button>
                                    </form>
                                @endif

                                <form action="{{ route('admin.reservations.destroy',$r) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Hapus reservasi #{{ $r->id }} ?')">
                                    @csrf @method('DELETE')
                                    <button class="px-3 py-1 rounded bg-red-600 text-white">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="p-3 border text-center" colspan="8">Belum ada reservasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
    </div>
</x-app-layout>
