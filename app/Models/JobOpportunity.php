<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class JobOpportunity extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'jobs';

    protected $fillable = [
        'title',
        'company',
        'description',
        'link',
        'type',
    ];
}
