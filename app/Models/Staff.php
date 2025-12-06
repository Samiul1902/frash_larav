<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Staff Model
 * Represents a stylist or employee at a branch.
 * @fr FR-03: Staff Management (Data Model)
 */
class Staff extends Model
{
    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'specialization',
        'bio',
        'is_active',
        'branch_id',
    ];

    /**
     * Get the user associated with the staff member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the branch the staff member belongs to.
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
