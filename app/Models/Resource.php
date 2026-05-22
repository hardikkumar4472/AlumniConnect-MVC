<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Resource extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'resources';

    protected $fillable = [
        'title',
        'type',
        'link',
        'description',
    ];
}
