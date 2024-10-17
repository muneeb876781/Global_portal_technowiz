<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignAPI extends Model
{
    use HasFactory;

    protected $fillable = ['app_id', 'api_url'];

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'app_id', 'app_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class, 'app_id');
    }

    public function blacklistedNumbers()
    {
        return $this->hasMany(BlacklistedNumbers::class, 'app_id', 'app_id');
    }
}
