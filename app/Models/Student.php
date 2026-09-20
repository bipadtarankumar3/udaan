<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'father_name',
        'dob',
        'phone',
        'whatsapp_no',
        'qualification',
        'gender',
        'address',
        'city',
        'course_interested',
        'email',
        'alt_phone',
        'source',
        'status',
        'priority',
        'assigned_to',
        'assigned_at',
        'assigned_by',
        'last_contacted_at',
        'next_followup_at',
        'current_remarks',
    ];

    protected function casts(): array
    {
        return [
            'dob' => 'date',
            'assigned_at' => 'datetime',
            'last_contacted_at' => 'datetime',
            'next_followup_at' => 'datetime',
        ];
    }

    /**
     * Assigned telecaller.
     */
    public function assignedTelecaller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Admin who assigned this student.
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Chronological remarks history.
     */
    public function remarks(): HasMany
    {
        return $this->hasMany(StudentRemark::class)->latest();
    }

    /**
     * Status badge color class for clean light UI.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'New' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'Contacted' => 'bg-blue-50 text-blue-700 border-blue-200',
            'Interested' => 'bg-amber-50 text-amber-700 border-amber-200',
            'Follow-up' => 'bg-purple-50 text-purple-700 border-purple-200',
            'Not Interested' => 'bg-rose-50 text-rose-700 border-rose-200',
            'Converted' => 'bg-teal-50 text-teal-700 border-teal-200',
            'Closed' => 'bg-slate-100 text-slate-700 border-slate-200',
            default => 'bg-slate-100 text-slate-600 border-slate-200',
        };
    }

    /**
     * Priority badge color class for clean light UI.
     */
    public function getPriorityBadgeClassAttribute(): string
    {
        return match ($this->priority) {
            'High' => 'bg-rose-50 text-rose-700 border-rose-200',
            'Medium' => 'bg-amber-50 text-amber-700 border-amber-200',
            'Low' => 'bg-slate-100 text-slate-600 border-slate-200',
            default => 'bg-slate-100 text-slate-600 border-slate-200',
        };
    }
}
