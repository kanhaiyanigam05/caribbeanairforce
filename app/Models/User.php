<?php

namespace App\Models;


use App\Enums\Role;
use App\Enums\Status;
use App\Enums\UserStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fname',
        'lname',
        'username',
        'email',
        'profile',
        'cover',
        'password',
        'city',
        'address',
        'company_name',
        'license_number',
        'license_file',
        'license_status',
        'address_proof',
        'address_proof_number',
        'address_proof_file',
        'address_proof_status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class,
            'role' => Role::class,
            'license_status' => Status::class,
            'address_proof_status' => Status::class,
            'license_file' => 'array',
            'address_proof_file' => 'array',
        ];
    }
    public function followers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'followed_id', 'follower_id')->withTimestamps();
    }

    public function following(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'followed_id')->withTimestamps();
    }
    public function isFollowing($userId): bool
    {
        return $this->following()->where('followed_id', $userId)->exists();
    }

    public function getProfileAttribute()
    {
        return $this->profiles !== null ? $this->profiles : 'https://ui-avatars.com/api/?name=' . substr($this->fname, 0, 1) . substr($this->lname, 0, 1) . '&size=45&background=random';
    }

    public function getBannerAttribute()
    {
        return $this->cover !== null ? $this->cover : asset('admins/images/profile/placeholder.svg');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->fname} {$this->lname}";
    }
    public function events(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id', 'id');
    }
    public function bookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(EventBooking::class, 'user_id', 'id');
    }
    public function membership(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Membership::class, 'user_id', 'id');
    }
    public function membership_booking(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(MembershipBooking::class, Membership::class);
    }
    public function membership_plan(): \Illuminate\Database\Eloquent\Relations\HasOneThrough
    {
        return $this->hasOneThrough(MembershipPlan::class, Membership::class);
    }
    public function templates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Template::class, 'user_id', 'id');
    }
    public function mail_lists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MailList::class, 'user_id', 'id');
    }
    public function mail_setting(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(MailSetting::class, 'user_id', 'id');
    }
    public function campaigns(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Campaign::class, 'user_id', 'id');
    }
    public function amenities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Amenity::class, 'user_id', 'id');
    }
}
