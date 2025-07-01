<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $fillable = ['title', 'slug', 'description', 'status'];
    public function events()
    {
        return $this->hasMany(Event::class, 'category_id', 'id');
    }
}