<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'room_type_id',
        'floor',
        'description'
    ];

    protected $with = ['roomType'];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function roomHistories()
    {
        return $this->hasMany(RoomHistory::class);
    }
}
