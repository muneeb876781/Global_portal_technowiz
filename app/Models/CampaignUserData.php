<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignUserData extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign_id',
        'user_count',
        'fetched_at',
    ];

    /**
     * Get the campaign that owns the user data.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
