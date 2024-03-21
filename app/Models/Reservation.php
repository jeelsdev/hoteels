<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'entry_date',
        'exit_date',
        'status_id',
        'origin',
    ];

    protected $dates = ['entry_date', 'exit_date'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function status()
    {
        return $this->belongsTo(ReservationStatus::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
