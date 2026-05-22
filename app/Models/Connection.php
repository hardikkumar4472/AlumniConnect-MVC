<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Connection extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'connections';

    protected $fillable = [
        'requester_id',
        'recipient_id',
        'status', // pending, accepted, rejected
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
