<?php

namespace Database\Seeders;

use App\Models\Reservation;
use App\Models\Room;
use App\Models\Tour;
use App\Models\User;
use App\Models\Xtra;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roomIds = Room::all()->pluck('id')->toArray();
        foreach ($roomIds as $roomId) {
            Reservation::factory()->count(rand(1, 5))->create([
                'room_id' => $roomId,
            ]);
        }

        $reservations = Reservation::all();
        $users = User::factory(10)->create();
        foreach ($users as $user) {
            $user->reservations()->attach(
                $reservations->random(rand(1, 3))->pluck('id')->toArray()
            , ['total' => random_int(50, 100), 'reserver' => true]);
        }

        $tours = Tour::factory(5)->create();
        foreach ($tours as $tour) {
            $tour->reservations()->attach(
                $reservations->random(rand(1, 3))->pluck('id')->toArray()
            , ['total' => random_int(10, 20), 'amount' => 1, 'paid' => true]);
        }

        $xtras = Xtra::factory(5)->create();
        foreach ($xtras as $xtra) {
            $xtra->reservations()->attach(
                $reservations->random(rand(1, 3))->pluck('id')->toArray()
            , ['total' => random_int(10, 20), 'amount' => 1, 'paid' => true]);
        }

        $reservationIds = $reservations->pluck('id')->toArray();
        foreach ($reservationIds as $reservationId) {
            $_r = Reservation::with('users')->find($reservationId);
            $totalReservation = null;
            if($_r){
                foreach ($_r->users as $user) {
                    if ($user->pivot->reserver) {
                        $totalReservation = $user->pivot->total;
                        break;
                    }
                }
            }
            \App\Models\Payment::factory()->create([
                'reservation_id' => $reservationId,
                'total_reservation' => $totalReservation? $totalReservation : 99,
            ]);
        }
    }
}
