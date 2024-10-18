<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlacklistedNumbers extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number', 'app_id', 'reason', 'is_blocked', 'blocked_at', 'unblocked_at', 'blacklisted_by', 'blacklisted_by_ip',
    ];

    protected $casts = [
        'blocked_at' => 'datetime',
        'unblocked_at' => 'datetime',
    ];

    /**
     * Define the relationship with the CampaignAPI model.
     * Each blacklisted number belongs to one campaign API (app).
     */
    public function campaignApi()
    {
        return $this->belongsTo(CampaignAPI::class, 'app_id', 'app_id');
    }
}
