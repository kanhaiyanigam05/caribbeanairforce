<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailList extends Model
{
    protected $fillable = ['name', 'description', 'status'];
    protected $casts = ['status' => 'boolean'];

    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'mail_list_subscribers', 'list_id', 'subscriber_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}