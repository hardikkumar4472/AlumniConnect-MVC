<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ResumeReview extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'resume_reviews';

    protected $fillable = [
        'student_id',
        'alumni_id',
        'resume_filename',
        'resume_url',
        'status',       // pending | reviewed
        'grade',        // scale of 1-10
        'feedback',
    ];

    protected $casts = [
        'grade' => 'integer',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function alumni()
    {
        return $this->belongsTo(User::class, 'alumni_id');
    }
}
