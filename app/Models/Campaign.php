<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'app_id', 'starts_at', 'pause_at', 'threshold'];

    // A campaign belongs to an application
    public function application()
    {
        return $this->belongsTo(Application::class, 'app_id');
    }

    public function userData()
    {
        return $this->hasMany(CampaignUserData::class);
    }

    public function campaignApi()
    {
        return $this->belongsTo(CampaignAPI::class, 'app_id', 'app_id');
    }
}
