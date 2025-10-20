@extends('layouts.app', ['title' => 'ElHotel – Temukan kamar terbaik'])

@section('hero')
    @include('partials.hero')
@endsection

@section('content')
    {{-- Kamar Terbaru --}}
    @php
        $featuredRooms = \App\Models\Room::where('status','available')
            ->latest('id')->take(6)->get();
    @endphp

    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl md:text-2xl font-semibold">Kamar Terbaru</h2>
        <a href="{{ route('rooms.index') }}" class="btn-ghost">Lihat semua</a>
    </div>

    @if($featuredRooms->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredRooms as $room)
                <div class="card overflow-hidden">
                    @if ($room->image_path)
                        <img src="{{ asset('storage/'.$room->image_path) }}"
                             alt="{{ $room->name }}"
                             class="h-48 w-full object-cover">
                    @else
                        <div class="h-48 w-full bg-gray-100"></div>
                    @endif

                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <h3 class="font-semibold text-lg">{{ $room->name }}</h3>
                            <span class="text-sm text-gray-500 capitalize">{{ $room->type }}</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Kapasitas {{ $room->capacity }} orang</p>
                        <p class="mt-2 font-semibold text-primary">
                            Rp {{ number_format($room->price_per_night,0,',','.') }}
                            <span class="font-normal text-gray-500 text-sm">/malam</span>
                        </p>

                        <div class="mt-4 flex items-center justify-between">
                            <a href="{{ route('rooms.show',$room) }}" class="btn-ghost">Detail</a>
                            <a href="{{ route('rooms.show',$room) }}" class="btn-primary">Pesan</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card p-6">
            <p class="text-gray-600">Belum ada kamar tersedia. Silakan cek kembali nanti.</p>
        </div>
    @endif

    {{-- Cara Kerja --}}
    <div class="mt-12">
        <h2 class="text-xl md:text-2xl font-semibold mb-4">Cara Kerja</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="card p-6">
                <div class="mb-3">
                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="text-primary font-bold">1</span>
                    </div>
                </div>
                <h3 class="font-semibold mb-1">Pilih Kamar</h3>
                <p class="text-gray-600 text-sm">Telusuri berbagai tipe kamar sesuai kebutuhan dan budget.</p>
            </div>
            <div class="card p-6">
                <div class="mb-3">
                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="text-primary font-bold">2</span>
                    </div>
                </div>
                <h3 class="font-semibold mb-1">Atur Tanggal</h3>
                <p class="text-gray-600 text-sm">Isi tanggal check-in & check-out kemudian buat reservasi.</p>
            </div>
            <div class="card p-6">
                <div class="mb-3">
                    <div class="h-10 w-10 rounded-full bg-primary/10 flex items-center justify-center">
                        <span class="text-primary font-bold">3</span>
                    </div>
                </div>
                <h3 class="font-semibold mb-1">Konfirmasi</h3>
                <p class="text-gray-600 text-sm">Admin akan mengonfirmasi reservasi. Pantau di “Reservasi Saya”.</p>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="mt-12">
        <div class="card overflow-hidden">
            <div class="bg-gradient-to-r from-primary to-primary-dark text-white p-8 md:p-10">
                <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <h3 class="text-2xl font-semibold">Siap staycation?</h3>
                        <p class="text-white/90 mt-1">Mulai cari kamar terbaik untuk perjalananmu.</p>
                    </div>
                    <a href="{{ route('rooms.index') }}" class="btn bg-white text-primary hover:bg-gray-100">
                        Jelajahi Kamar
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
