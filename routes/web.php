<?php

use App\Http\Controllers\ReservationController;
use App\Livewire\Admin\Dashboard\Debtor\Debtor;
use App\Livewire\Admin\Dashboard\Diary\DailyIncome;
use App\Livewire\Admin\Dashboard\Report\Report;
use App\Livewire\Admin\Movement\Expenses;
use App\Livewire\Admin\Movement\Index;
use App\Livewire\Admin\Reservation\EditReservation;
use App\Livewire\Admin\Reservation\List\ReservationList;
use App\Livewire\Admin\Room\CreateRoom;
use App\Livewire\Admin\Room\EditRoom;
use App\Livewire\Admin\Room\Floor\Floor;
use App\Livewire\Admin\Room\Rooms;
use App\Livewire\Admin\Room\SeeRoom;
use App\Livewire\Admin\Room\ShowRooms;
use App\Livewire\Admin\Room\Type\Types;
use App\Livewire\Admin\Service\Tour\CreateTour;
use App\Livewire\Admin\Service\Tour\Tours;
use App\Livewire\Admin\Service\Xtra\CreateXtra;
use App\Livewire\Admin\Service\Xtra\Xtras;
use App\Livewire\Admin\User\CreateUser;
use App\Livewire\Admin\User\EditUser;
use App\Livewire\Admin\User\History\History;
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
    Route::prefix('/dashboard')->name('dashboard.')->group(function () {
        Route::get('/', Report::class)->name('report');
    });
    
    Route::prefix('reservation')->name('reservation.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/create/{data}', [ReservationController::class, 'create'])->name('create');
        Route::get('/edit/{data}', EditReservation::class)->name('edit');
        Route::get('/list', ReservationList::class)->name('list');
    });
    
    Route::prefix('room')->name('room.')->group(function () {
        Route::get('/', ShowRooms::class)->name('index');
        Route::get('/create', CreateRoom::class)->name('create');
        Route::get('/edit/{id}', EditRoom::class)->name('edit');
        Route::get('/show/{id}', SeeRoom::class)->name('see');
        Route::get('/floor', Floor::class)->name('floor');
        Route::get('/types', Types::class)->name('types');
        Route::get('/rooms', Rooms::class)->name('rooms');
    });
    
    Route::prefix('room')->group(function () {
        Route::get('/edit', EditReservation::class)->name('edit.index');
    });
    
    Route::prefix('users')->group(function () {
        Route::get('/', Users::class)->name('users.index');
        Route::get('/create', CreateUser::class)->name('user.create');
        Route::get('/edit/{id}', EditUser::class)->name('user.edit');
        Route::get('/debtors', Debtor::class)->name('users.debtors');
        Route::get('/history/{id}', History::class)->name('user.history');
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

    Route::prefix('movement')->name('movement.')->group(function() {
        Route::get('/', Index::class)->name('index');
        Route::get('/daily-income', DailyIncome::class)->name('daily-income');
        Route::get('/expenses', Expenses::class)->name('expenses');
    });

    Route::prefix('profile')->name('profile.')->group(function() {
        Route::get('/config', function(){
            return view('profile.show');
        })->name('show');
    });
});
