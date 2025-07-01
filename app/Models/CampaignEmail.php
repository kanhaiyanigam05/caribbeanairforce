<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignEmail extends Model
{
    protected $fillable = ['campaign_id', 'email', 'status'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id', 'id');
    }
}