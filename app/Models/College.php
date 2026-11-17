<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'city',
        'state',
        'address',
        'affiliation',
        'contact_person',
        'phone',
        'email',
        'website',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get student bills associated with this college.
     */
    public function studentBills(): HasMany
    {
        return $this->hasMany(StudentBill::class, 'college_id');
    }

    /**
     * Scope for active colleges.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
