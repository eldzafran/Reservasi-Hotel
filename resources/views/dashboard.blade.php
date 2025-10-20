<x-app-layout>
    <div class="max-w-4xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Dashboard</h1>
        <p>Halo, {{ auth()->user()->name }}!</p>
        <div class="mt-4 flex gap-3">
            <a href="{{ route('rooms.index') }}" class="px-4 py-2 rounded bg-blue-600 text-white">Lihat Kamar</a>
            <a href="{{ route('profile.edit') }}" class="px-4 py-2 rounded bg-gray-700 text-white">Edit Profil</a>
        </div>
    </div>
</x-app-layout>
