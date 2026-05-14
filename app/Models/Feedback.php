<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Feedback extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'feedback';

    protected $fillable = [
        'user_id',
        'subject',
        'message',
    ];
}
