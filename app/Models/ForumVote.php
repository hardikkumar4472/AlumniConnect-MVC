<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ForumVote extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'forum_votes';

    protected $fillable = [
        'user_id',
        'votable_id',
        'votable_type', // 'question' | 'answer'
        'type',         // 'upvote' | 'downvote'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
