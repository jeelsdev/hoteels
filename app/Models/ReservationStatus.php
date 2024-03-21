<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationStatus extends Model
{
    use HasFactory;

    protected $fillable = ['status'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'status_id');
    }

}
