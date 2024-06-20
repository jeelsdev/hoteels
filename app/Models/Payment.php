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

    public function salesFromPreviousDay()
    {
        return Payment::whereDate('created_at', today()->subDay())
            ->sum('total_reservation');
    }

    public function salesFromCurrentDay()
    {
        return Payment::whereDate('created_at', today())
            ->sum('total_reservation');
    }

    public function earningsFromPreviousDay()
    {
        $totalSales = Payment::whereDate('created_at', today()->subDay())
            ->sum('total_reservation');
        return $totalSales * 0.18;
    }

    public function earningsFromCurrentDay()
    {
        $totalSales = Payment::whereDate('created_at', today())
            ->sum('total_reservation');
        return $totalSales * 0.18;
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
