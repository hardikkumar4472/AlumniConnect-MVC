<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class ForumQuestion extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'forum_questions';

    protected $fillable = [
        'user_id',
        'user_name',
        'title',
        'body',
        'tags',
        'views',
        'accepted_answer_id',
    ];

    protected $casts = [
        'tags'  => 'array',
        'views' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function answers()
    {
        return $this->hasMany(ForumAnswer::class, 'question_id');
    }

    public function acceptedAnswer()
    {
        return $this->belongsTo(ForumAnswer::class, 'accepted_answer_id');
    }
}
