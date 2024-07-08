<?php

namespace App\Http\Controllers;

use App\Livewire\Admin\Room\Rooms;
use App\Models\Room;
use App\Models\RoomHistory;
use Illuminate\Http\Request;

class RoomHistoryController extends Controller
{
    public function checkStatusRooms()
    {
        $rooms = Room::all();
        foreach($rooms as $room) {
            $roomHistory = RoomHistory::where('room_id', $room->id)
                ->whereDate('from', '<=', now()->format('Y-m-d'))
                ->whereDate('to', '>=', now()->format('Y-m-d'))
                ->latest()
                ->first();
            if($roomHistory) {
                if($roomHistory->to->isToday() && now()->lessThan($roomHistory->to)) {
                    $room->status = 'exit';
                    $room->save();
                }elseif($roomHistory->to->isToday() && now()->greaterThan($roomHistory->to)){
                    $room->status = 'available';
                    $room->save();
                }else{
                    $room->status = 'clean';
                    $room->save();
                }
            }else{
                $room->status = 'available';
                $room->save();
            }
        }
    }
}
