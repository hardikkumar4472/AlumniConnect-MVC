<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ForumAnswer extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'forum_answers';

    protected $fillable = [
        'question_id',
        'user_id',
        'user_name',
        'body',
        'upvotes',
        'is_accepted',
    ];

    protected $casts = [
        'upvotes'     => 'integer',
        'is_accepted' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function question()
    {
        return $this->belongsTo(ForumQuestion::class, 'question_id');
    }
}
