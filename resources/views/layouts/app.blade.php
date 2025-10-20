<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'ElHotel' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-ink">

    <!-- HEADER -->
    <header class="bg-gradient-to-b from-primary to-primary-dark text-white">
        <div class="mx-auto max-w-7xl px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold">
                <svg width="28" height="28" viewBox="0 0 24 24" class="-mt-0.5" aria-hidden="true">
                    <path fill="currentColor" d="M12 2l7 7-1.4 1.4L18 9.8V20a2 2 0 0 1-2 2h-4v-6H8v6H6a2 2 0 0 1-2-2V9.8L6.4 10.4 5 9z"/>
                </svg>
                <span class="text-xl">ElHotel</span>
            </a>

            <nav class="flex items-center gap-2">
                <a href="{{ route('rooms.index') }}" class="btn-ghost hidden sm:inline-flex">Jelajahi Kamar</a>

                @auth
                    <a href="{{ route('reservations.mine') }}" class="btn-ghost hidden sm:inline-flex">Reservasi Saya</a>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="btn-ghost hidden md:inline-flex">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button class="btn bg-white/10 hover:bg-white/20 text-white">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn bg-white text-primary hover:bg-gray-100">Masuk</a>
                    <a href="{{ route('register') }}" class="btn bg-accent text-white hover:opacity-90">Daftar</a>
                @endauth
            </nav>
        </div>

        <!-- Hero (opsional) -->
        <div class="mx-auto max-w-7xl px-4 pb-10">
            @yield('hero')
        </div>
    </header>

    <!-- FLASH -->
    @if (session('success'))
        <div class="mx-auto max-w-7xl px-4 mt-6">
            <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mx-auto max-w-7xl px-4 mt-6">
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- CONTENT -->
    <main class="mx-auto max-w-7xl px-4 py-10">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="border-t bg-white">
        <div class="mx-auto max-w-7xl px-4 py-8 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-sm text-gray-500">© {{ date('Y') }} ElHotel. All rights reserved.</p>
            <div class="flex gap-4 text-sm">
                <a class="text-gray-600 hover:text-ink" href="{{ route('rooms.index') }}">Kamar</a>
                <a class="text-gray-600 hover:text-ink" href="#">Kebijakan Privasi</a>
                <a class="text-gray-600 hover:text-ink" href="#">Bantuan</a>
            </div>
        </div>
    </footer>

</body>
</html>
