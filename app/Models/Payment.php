<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'total_reservation',
        'advance_reservation',
        'total_xtras',
        'advance_xtras',
        'total_tours',
        'advance_tours',
        'type'
    ];
}
