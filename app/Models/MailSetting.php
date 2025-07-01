<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailSetting extends Model
{
    protected $fillable = ['user_id', 'providor', 'host', 'port', 'encryption', 'username', 'password', 'from_email', 'from_name'];
    protected $hidden = ['password'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}