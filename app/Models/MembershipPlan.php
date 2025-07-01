<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPlan extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'available_features', 'not_available_features', 'price', 'duration', 'trial', 'status'];
    protected $casts = ['available_features' => 'array', 'not_available_features' => 'array', 'price' => 'decimal:2', 'status' => 'boolean'];

    public function memberships()
    {
        return $this->hasMany(Membership::class, 'membership_id');
    }
    public function users()
    {
        return $this->hasManyThrough(User::class, Membership::class);
    }
}
