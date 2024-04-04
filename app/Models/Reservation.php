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
        'total',
        'pending_payment',
    ];

    protected $cast = [
        'origin' => Origin::class,
        'status' => Status::class,
        'entry_date' => 'date',
        'exit_date' => 'date',
    ];

    protected $with = ['users', 'payment', 'xtras', 'tours'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function xtras()
    {
        return $this->belongsToMany(Xtra::class);
    }

    public function tours()
    {
        return $this->belongsToMany(Tour::class);
    }
}
