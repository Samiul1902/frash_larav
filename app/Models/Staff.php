<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name',
        'specialization',
        'bio',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
