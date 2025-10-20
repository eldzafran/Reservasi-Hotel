@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold">Halo, {{ auth()->user()->name }} 👋</h1>
            <p class="text-gray-600 text-sm mt-1">Kelola reservasi atau mulai cari kamar.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('rooms.index') }}" class="btn-primary">Cari Kamar</a>
            <a href="{{ route('reservations.mine') }}" class="btn-ghost">Reservasi Saya</a>
        </div>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        <div class="card p-6">
            <h3 class="font-semibold">Profil</h3>
            <p class="text-gray-600 text-sm mt-1">Perbarui nama/email atau ganti password.</p>
            <a href="{{ route('profile.edit') }}" class="btn-ghost mt-3">Edit Profil</a>
        </div>
        <div class="card p-6">
            <h3 class="font-semibold">Reservasi</h3>
            <p class="text-gray-600 text-sm mt-1">Lihat daftar & batalkan sebelum check-in.</p>
            <a href="{{ route('reservations.mine') }}" class="btn-ghost mt-3">Lihat Reservasi</a>
        </div>
        @if(auth()->user()->isAdmin())
        <div class="card p-6">
            <h3 class="font-semibold">Admin</h3>
            <p class="text-gray-600 text-sm mt-1">Kelola kamar & konfirmasi reservasi.</p>
            <a href="{{ route('admin.dashboard') }}" class="btn-ghost mt-3">Masuk Admin</a>
        </div>
        @endif
    </div>
@endsection
