<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = ['user_id', 'plan_id', 'start_date', 'end_date', 'canceled_at'];
    protected $casts = ['status' => 'boolean'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plan()
    {
        return $this->belongsTo(MembershipPlan::class, 'plan_id');
    }
    public function booking()
    {
        return $this->hasOne(MembershipBooking::class, 'membership_id');
    }
}
