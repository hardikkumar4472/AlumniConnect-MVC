<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class SuccessStory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'success_stories';

    protected $fillable = [
        'name',
        'designation',
        'story',
        'image',
        'is_featured',
    ];
}
