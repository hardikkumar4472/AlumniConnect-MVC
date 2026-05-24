<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class EventRsvp extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'event_rsvps';

    protected $fillable = [
        'user_id',
        'event_id',
        'status',       // going | interested | not_going
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function event()
    {
        return $this->belongsTo(AlumniEvent::class, 'event_id');
    }
}
