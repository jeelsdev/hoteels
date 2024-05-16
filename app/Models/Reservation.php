<?php

namespace App\Models;

use App\Enums\Origin;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'entry_date',
        'exit_date',
        'status',
        'origin',
        'comments',
    ];

    protected $cast = [
        'origin' => Origin::class,
        'status' => Status::class,
        'entry_date' => 'date',
        'exit_date' => 'date',
    ];

    protected $with = ['users', 'payment', 'xtras', 'tours'];

    public function profits()
    {
        $totalSales =  Payment::whereDate('created_at', today())
            ->sum('total_reservation');
        return $totalSales * 0.18;
    }

    public function totalReservations()
    {
        return Reservation::whereDate('created_at', today())
            ->count();
    }

    public function totalSales()
    {
        return Payment::whereDate('created_at', today())->sum('total_reservation');
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('total', 'reserver');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function xtras()
    {
        return $this->belongsToMany(Xtra::class)->withPivot('total', 'amount', 'paid');
    }

    public function tours()
    {
        return $this->belongsToMany(Tour::class)->withPivot('total', 'amount', 'paid');
    }
}
