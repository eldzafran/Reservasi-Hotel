<x-app-layout>
    <div class="max-w-2xl mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Edit Profil</h1>

        @if (session('success'))
            <div class="p-3 mb-4 bg-green-100 border border-green-300 rounded">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border rounded px-3 py-2">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded px-3 py-2">
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="p-4 border rounded">
                <p class="font-medium mb-2">Ganti Password (opsional)</p>
                <div class="grid gap-3">
                    <div>
                        <label class="block text-sm mb-1">Password Baru</label>
                        <input type="password" name="password" class="w-full border rounded px-3 py-2">
                        @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm mb-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
            </div>

            <button class="px-4 py-2 rounded bg-blue-600 text-white">Simpan</button>
        </form>

        <hr class="my-8">

        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Yakin hapus akun? Tindakan ini tidak bisa dibatalkan.')">
            @csrf
            @method('DELETE')

            <div class="mb-3">
                <label class="block text-sm mb-1">Konfirmasi Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2">
            </div>

            <button class="px-4 py-2 rounded bg-red-600 text-white">Hapus Akun</button>
        </form>
    </div>
</x-app-layout>
