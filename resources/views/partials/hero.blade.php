{{-- HERO CARD --}}
<div class="mx-auto max-w-5xl">
    <div class="card rounded-2xl shadow-soft bg-white">
        <div class="p-6 md:p-8">
            <h1 class="text-3xl md:text-4xl font-semibold text-ink tracking-tight">
                Cari & Pesan Kamar Hotel
            </h1>
            <p class="text-gray-600 mt-2">
                Temukan kamar terbaik dengan harga bersahabat.
            </p>

            {{-- Form pencarian ringkas --}}
            <form method="GET" action="{{ route('rooms.index') }}"
                  class="mt-6 grid grid-cols-1 md:grid-cols-12 gap-3">
                {{-- Kata kunci --}}
                <div class="md:col-span-5">
                    <input
                        class="w-full rounded-lg border-gray-200"
                        type="text"
                        name="q"
                        placeholder="Nama kamar / kata kunci"
                        value="{{ request('q') }}"
                    >
                </div>

                {{-- Tipe kamar --}}
                <div class="md:col-span-4">
                    <div class="relative">
                        <select
                            class="w-full appearance-none rounded-lg border-gray-200 pr-10"
                            name="type"
                        >
                            <option value="">Semua tipe</option>
                            @foreach (['standard','deluxe','suite'] as $t)
                                <option value="{{ $t }}" @selected(request('type')==$t)>
                                    {{ ucfirst($t) }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400"
                             viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                {{-- Kapasitas --}}
                <div class="md:col-span-2">
                    <input
                        class="w-full rounded-lg border-gray-200"
                        type="number" min="1" name="capacity"
                        placeholder="Kapasitas"
                        value="{{ request('capacity') }}"
                    >
                </div>

                {{-- Tombol --}}
                <div class="md:col-span-1">
                    <button class="btn-primary w-full">Cari</button>
                </div>
            </form>
        </div>
    </div>
</div>
