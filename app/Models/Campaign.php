<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $fillable = ['user_id', 'subject', 'body', 'attachments'];
    protected $casts = ['attachments' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function campaign_emails()
    {
        return $this->hasMany(CampaignEmail::class, 'campaign_id', 'id');
    }
}