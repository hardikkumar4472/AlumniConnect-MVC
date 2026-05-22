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
        'posted_by'
    ];

    public function poster()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }
}
