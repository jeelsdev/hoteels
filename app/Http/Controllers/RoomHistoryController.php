<?php

namespace App\Http\Controllers;

use App\Models\RoomHistory;
use Illuminate\Http\Request;

class RoomHistoryController extends Controller
{
    public function checkStatusRooms()
    {
        $occupiedRooms = RoomHistory::whereDate('from', '<=', now())
            ->whereDate('to', '>=', now())
            ->where('status', 'occupied')
            ->get();

        if($occupiedRooms->count() > 0) {
            foreach($occupiedRooms as $roomHistory) {
                $roomHistory->room->status = $roomHistory->status;
                $roomHistory->room->save();
            }
        }

        $availableRooms = RoomHistory::whereDate('from', '>', now())
            ->whereDate('to', '<', now())
            ->where('status', 'occupied')
            ->get();
        
        if($availableRooms->count() > 0) {
            foreach($availableRooms as $roomHistory) {
                $roomHistory->room->status = 'available';
                $roomHistory->room->save();
            }
        }
    }
}
