<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Alumni extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'users';

    protected $fillable = [
        'name',
        'email',
        'graduation_year',
        'field_of_study',
        'industry',
        'location',
        'bio',
        'skills',
        'is_active',
    ];
}
