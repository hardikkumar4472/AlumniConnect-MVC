<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Donation extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'donations';

    protected $fillable = [
        'contributor_name',
        'purpose',
        'amount',
        'image',
    ];
}
