<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class CampusNews extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'campus_news';

    protected $fillable = [
        'title',
        'content',
        'date',
    ];
}
