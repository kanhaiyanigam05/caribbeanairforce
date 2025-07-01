<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBooking extends Model
{
    use HasFactory;

    protected $fillable = ['event_id', 'ticket_id', 'user_id', 'fname', 'lname', 'email', 'phone', 'phone', 'tickets', 'packages', 'slots', 'total'];
    protected $casts = ['slots' => 'array', 'packages' => 'array'];
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
