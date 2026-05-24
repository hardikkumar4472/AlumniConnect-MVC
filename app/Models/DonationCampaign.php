<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class DonationCampaign extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'donation_campaigns';

    protected $fillable = [
        'created_by',
        'creator_name',
        'title',
        'description',
        'goal_amount',
        'raised_amount',
        'category',
        'is_active',
    ];

    protected $casts = [
        'goal_amount'   => 'float',
        'raised_amount' => 'float',
        'is_active'     => 'boolean',
    ];

    public function getProgressPercentageAttribute(): float
    {
        if ($this->goal_amount <= 0) return 0;
        return min(100, round(($this->raised_amount / $this->goal_amount) * 100, 1));
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
