<?php

use App\Http\Controllers\ReservationController;
use App\Livewire\Admin\Reservation\ShowReservations;
use App\Livewire\Admin\Room\ShowRooms;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::prefix('reservation')->group(function () {
        Route::get('/', ShowReservations::class)->name('reservation.index');
    });

    Route::prefix('room')->group(function () {
        Route::get('/', ShowRooms::class)->name('room.index');
    });
});
