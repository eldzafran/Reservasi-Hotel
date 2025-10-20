<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth routes dari Breeze
require __DIR__ . '/auth.php';

// ------------------------------
// USER AREA (harus login)
// ------------------------------
Route::middleware(['auth'])->group(function () {
    // Dashboard user
    Route::get('/dashboard', function () {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Profile (supaya route('profile.edit') tidak error)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reservasi user
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/my-reservations', [ReservationController::class, 'myReservations'])->name('reservations.mine');
});

// ------------------------------
// PUBLIC AREA
// ------------------------------
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

// ------------------------------
// ADMIN AREA (pakai class middleware langsung)
// ------------------------------
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // CRUD kamar
        Route::resource('rooms', AdminRoomController::class);

        // (opsional) jika nanti ingin tambah route konfirmasi reservasi
        // use App\Http\Controllers\Admin\ReservationAdminController;
        // Route::patch('/reservations/{reservation}/confirm', [ReservationAdminController::class, 'confirm'])->name('reservations.confirm');
        // Route::patch('/reservations/{reservation}/cancel', [ReservationAdminController::class, 'cancel'])->name('reservations.cancel');
    });
