<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class AlumniEvent extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'events';

    protected $fillable = [
        'title',
        'date',
        'month',
        'time',
        'location',
        'type',
    ];
}
