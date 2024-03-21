<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(20)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $room_types = [
            [1,"Habitación con cama extragrande y balcón",	124],
            [2,"Habitación triple con baño privado"	,168],
            [3,"Habitación familiar con baño privado", 185],
            [4,"Habitación individual con baño compartido",	74],
            [5,"Habitación individual con baño privado",84],
            [6,"Habitación doble con baño compartido", 84],
            [7,"Habitación doble con baño privado", 97],
            [8,"Habitación familiar con baño privado",146],
        ];

        foreach ($room_types as $room_type) {
            \App\Models\RoomType::create([
                'id' => $room_type[0],
                'description' => $room_type[1],
                'price' => $room_type[2],
            ]);
        }

        $this->call(RoomSeeder::class);

        $reservation_status = [
            [1,"Pending"],
            [2,"Confirmed"],
            [3,"Cancelled"],
        ];

        foreach ($reservation_status as $status) {
            \App\Models\ReservationStatus::create([
                'id' => $status[0],
                'status' => $status[1],
            ]);
        }

        // $this->call(ReservationSeeder::class);
        $reservations = Reservation::factory(20)->create();

        $this->call(PaymentSeeder::class);

        foreach ($users as $user) {
            $user->reservations()->attach(
                $reservations->random(rand(1, 3))->pluck('id')->toArray()
            );
        }


    }
}
