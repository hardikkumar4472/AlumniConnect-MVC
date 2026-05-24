<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class MentorshipSession extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'mentorship_sessions';

    protected $fillable = [
        'mentor_id',
        'mentee_id',
        'status',       // pending | active | completed | rejected
        'message',
        'milestones',   // array of tasks
        'feedback',
        'rating',
    ];

    protected $casts = [
        'milestones' => 'array',
        'rating'     => 'integer',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id');
    }
}
