<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipBooking extends Model
{
    protected $fillable = ['membership_number', 'membership_id', 'fname', 'lname', 'email', 'phone', 'transaction_id', 'amount'];
    protected $casts = ['amount' => 'decimal:2'];

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id');
    }
}
