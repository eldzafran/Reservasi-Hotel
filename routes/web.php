<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('welcome'))->name('home');

// Auth routes dari Breeze
require __DIR__ . '/auth.php';

/* ------------------------------
| USER AREA (login)
|------------------------------ */
Route::middleware(['auth'])->group(function () {
    // Dashboard user
    Route::get('/dashboard', function () {
        if (auth()->check() && auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Aksi pesan & halaman "Reservasi Saya"
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/my-reservations', [ReservationController::class, 'myReservations'])->name('reservations.mine');
    Route::patch('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');
});

/* ------------------------------
| PUBLIC AREA (tanpa login)
|------------------------------ */
Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');   // daftar kamar
Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show'); // detail + form pesan

/* ------------------------------
| ADMIN AREA
|------------------------------ */
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('rooms', AdminRoomController::class);

        Route::get('/reservations', [ReservationAdminController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/{reservation}', [ReservationAdminController::class, 'show'])->name('reservations.show');
        Route::patch('/reservations/{reservation}/confirm', [ReservationAdminController::class, 'confirm'])->name('reservations.confirm');
        Route::patch('/reservations/{reservation}/cancel', [ReservationAdminController::class, 'cancel'])->name('reservations.cancel');
        Route::delete('/reservations/{reservation}', [ReservationAdminController::class, 'destroy'])->name('reservations.destroy');
    });
