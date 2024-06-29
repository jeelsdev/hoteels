<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'room_id',
        'status',
        'from',
        'to'
    ];
    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime'
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
