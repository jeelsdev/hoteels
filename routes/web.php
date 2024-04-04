<?php

use App\Http\Controllers\ReservationController;
use App\Livewire\Admin\Dashboard\Dashboard;
use App\Livewire\Admin\Reservation\EditReservation;
use App\Livewire\Admin\Reservation\ShowReservations;
use App\Livewire\Admin\Room\ShowRooms;
use App\Livewire\Admin\User\Users;
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
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::prefix('reservation')->group(function () {
        Route::get('/', ShowReservations::class)->name('reservation.index');
    });

    Route::prefix('room')->group(function () {
        Route::get('/', ShowRooms::class)->name('room.index');
    });

    Route::prefix('room')->group(function () {
        Route::get('/edit', EditReservation::class)->name('edit.index');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', Users::class)->name('users.index');
    });
    
});
