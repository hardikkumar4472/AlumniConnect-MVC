<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Donation extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'donations';

    protected $fillable = [
        'user_id',
        'user_name',
        'campaign_id',
        'purpose',
        'amount',
        'order_id',
        'payment_id',
        'status',       // pending | success | failed
        'message',
        // legacy fields
        'contributor_name',
        'image',
    ];

    protected $casts = [
        'amount' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function campaign()
    {
        return $this->belongsTo(DonationCampaign::class, 'campaign_id');
    }
}
