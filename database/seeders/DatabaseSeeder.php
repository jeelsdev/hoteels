<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Expense;
use App\Models\Floor;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Tour;
use App\Models\User;
use App\Models\Xtra;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'surname' => 'Test Surname',
            'document' => '12345678',
            'document_type' => 'DNI',
            'phone' => '123456789',
            'email' => 'admin@yopmail.com',
            'password' => '$2y$10$nJDvcBbax3S3Q4JEMreuWOkaG6DW6COUHmKjXs2zpnsV8Yk9XNBlO', // 12345678
            'favorite' => false,
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'current_team_id' => null,
        ]);

        $room_types = [
            [1,"Simple","S",50],
            [2,"Doble","D",68],
            [3,"Triple","T", 80],
            [4,"Matrimonial","M",99],
        ];

        foreach ($room_types as $room_type) {
            \App\Models\RoomType::create([
                'id' => $room_type[0],
                'description' => $room_type[1], // 'Simple', 'Doble', 'Triple', 'Matrimonial'
                'denomination' => $room_type[2],
                'price' => $room_type[3],
            ]);
        }

        $floors = [
            [1,'Primer piso','1'],
            [2,'Segundo piso','2'],
        ];

        foreach ($floors as $floors_type) {
            Floor::create([
                'id' => $floors_type[0],
                'description' => $floors_type[1],
                'denomination' => $floors_type[2],
            ]);
        }

        $this->call(RoomSeeder::class);

        // $this->call(ReservationSeeder::class);
        $roomIds = Room::all()->pluck('id')->toArray();
        foreach ($roomIds as $roomId) {
            Reservation::factory()->create([
                'room_id' => $roomId,
            ]);
        }
        $reservations = Reservation::all();

        foreach ($users as $user) {
            $user->reservations()->attach(
                $reservations->random(rand(1, 3))->pluck('id')->toArray()
            , ['total' => random_int(50, 100), 'reserver' => true]);
        }

        $tours = Tour::factory(20)->create();
        foreach ($tours as $tour) {
            $tour->reservations()->attach(
                $reservations->random(rand(1, 3))->pluck('id')->toArray()
            , ['total' => random_int(10, 20), 'amount' => 1, 'paid' => true]);
        }

        $xtras = Xtra::factory(20)->create();
        foreach ($xtras as $xtra) {
            $xtra->reservations()->attach(
                $reservations->random(rand(1, 3))->pluck('id')->toArray()
            , ['total' => random_int(10, 20), 'amount' => 1, 'paid' => true]);
        }

        // $this->call(PaymentSeeder::class);
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

        Expense::factory(20)->create();

    }
}
