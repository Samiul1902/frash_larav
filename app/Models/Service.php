<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['title', 'description', 'price', 'duration_minutes', 'is_active', 'image', 'branch_id'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
