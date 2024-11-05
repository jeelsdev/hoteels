<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;
use Carbon\Carbon;
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

    public function create($data): View
    {
        parse_str($data, $data);

        try {
            $date = Carbon::parse($data['date']);
            $room = Room::findOrFail($data['resource']);
        } catch (\Throwable $th) {
            return redirect()->route('reservation.index');
        }

        return view('admin.reservation.create', compact('date', 'room'));
    }
}
