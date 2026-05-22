<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class JobApplication extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'job_applications';

    protected $fillable = [
        'job_id',
        'applicant_id',
        'resume_path',
        'status', // pending, reviewed, accepted, rejected
    ];

    public function job()
    {
        return $this->belongsTo(JobOpportunity::class, 'job_id');
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }
}
