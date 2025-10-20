<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Dashboard</h1>
        <p>Halo, {{ auth()->user()->name }}!</p>
        <div class="mt-4 flex flex-wrap gap-3">
            <a href="{{ route('rooms.index') }}" class="px-4 py-2 rounded bg-blue-600 text-white">Lihat Kamar</a>
            <a href="{{ route('reservations.mine') }}" class="px-4 py-2 rounded bg-indigo-600 text-white">Reservasi Saya</a>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded bg-gray-700 text-white">Edit Profil</a>
            @if (auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded bg-emerald-600 text-white">Admin Dashboard</a>
            @endif
        </div>
    </div>
</x-app-layout>
