<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'price',
        'duration_minutes',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
