<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image'];

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'app_id');
    }

    public function campaignApis()
    {
        return $this->hasMany(CampaignAPI::class, 'app_id');
    }
}
