<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function index(): View
    {
        $rooms = Room::with('roomType')
            ->orderBy('floor', 'asc')
            ->get();
        $reservations = Reservation::all();

        return view('admin.reservation.index', compact('rooms', 'reservations'));
    }
}
