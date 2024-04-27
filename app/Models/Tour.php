<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class)->withPivot('total');
    }
}
