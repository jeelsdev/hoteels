<?php

use App\Http\Controllers\ReservationController;
use App\Livewire\Admin\Dashboard\Dashboard;
use App\Livewire\Admin\Dashboard\Debtor\Debtor;
use App\Livewire\Admin\Dashboard\Diary\DailyIncome;
use App\Livewire\Admin\Dashboard\Report\Report;
use App\Livewire\Admin\Reservation\CreateReservation;
use App\Livewire\Admin\Reservation\EditReservation;
use App\Livewire\Admin\Reservation\List\ReservationList;
use App\Livewire\Admin\Reservation\ShowReservations;
use App\Livewire\Admin\Room\CreateRoom;
use App\Livewire\Admin\Room\EditRoom;
use App\Livewire\Admin\Room\ShowRooms;
use App\Livewire\Admin\Service\Tour\CreateTour;
use App\Livewire\Admin\Service\Tour\Tours;
use App\Livewire\Admin\Service\Xtra\CreateXtra;
use App\Livewire\Admin\Service\Xtra\Xtras;
use App\Livewire\Admin\User\CreateUser;
use App\Livewire\Admin\User\EditUser;
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
])->prefix('/admin')->group(function () {
    Route::prefix('/dashboard')->group(function () {
        Route::get('/report', Report::class)->name('dashboard.report');
        Route::get('/daily-income', DailyIncome::class)->name('dashboard.daily-income');
        Route::get('/debtors', Debtor::class)->name('dashboard.debtors');
    });

    Route::prefix('reservation')->group(function () {
        Route::get('/', ShowReservations::class)->name('reservation.index');
        Route::get('/create/{data}', CreateReservation::class)->name('reservation.create');
        Route::get('/edit/{data}', EditReservation::class)->name('reservation.edit');
        Route::get('/list', ReservationList::class)->name('reservation.list');
    });

    Route::prefix('room')->group(function () {
        Route::get('/', ShowRooms::class)->name('room.index');
        Route::get('/create', CreateRoom::class)->name('room.create');
        Route::get('/edit/{id}', EditRoom::class)->name('room.edit');
    });

    Route::prefix('room')->group(function () {
        Route::get('/edit', EditReservation::class)->name('edit.index');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', Users::class)->name('users.index');
        Route::get('/create', CreateUser::class)->name('user.create');
        Route::get('/edit/{id}', EditUser::class)->name('user.edit');
    });

    Route::prefix('service')->group(function() {
        Route::prefix('xtras')->group(function() {
            Route::get('/', Xtras::class)->name('xtras.index');
            Route::get('/create', CreateXtra::class)->name('xtra.create');
        });
        Route::prefix('tour')->group(function() {
            Route::get('/', Tours::class)->name('tours.index');
            Route::get('/create', CreateTour::class)->name('tour.create');
        });
    });
    
});
