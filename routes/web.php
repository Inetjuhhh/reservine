<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::get('/filterReservations', function () {
    return view('filter-reservations');
})->middleware(['auth', 'verified'])->name('filterReservations');

Route::get('/tables', [ReservationController::class, 'tablesOfToday'])
    ->middleware(['auth', 'verified'])
    ->name('tables');

Route::get('/reservations/{table}', [ReservationController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('reservations.show');

Route::get('/reservations', [ReservationController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('reservations');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
