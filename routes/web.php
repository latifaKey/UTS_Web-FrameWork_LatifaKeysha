<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

// Rute Autentikasi
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Rute untuk pengguna yang sudah login
Route::middleware('auth')->group(function () {
    // Redirect ke halaman utama
    Route::get('/', function () {
        return redirect()->route('booking.index');
    });

    // Rute untuk semua pengguna
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');

    // Rute untuk edit dan update booking (untuk semua pengguna)
    Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');

    // Rute khusus admin
    Route::middleware('can:admin')->group(function () {
        // Fungsi persetujuan booking
        Route::get('/booking-pending', [BookingController::class, 'pending'])->name('booking.pending');
        Route::post('/booking-approve/{id}', [BookingController::class, 'approve'])->name('booking.approve');

        // Fitur hapus (hanya admin)
        Route::delete('/booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');

        // Rute untuk fitur soft delete
        Route::get('/booking-trash', [BookingController::class, 'trash'])->name('booking.trash');
        Route::post('/booking-restore/{id}', [BookingController::class, 'restore'])->name('booking.restore');
        Route::delete('/booking-force-delete/{id}', [BookingController::class, 'forceDelete'])->name('booking.force-delete');
    });
});
