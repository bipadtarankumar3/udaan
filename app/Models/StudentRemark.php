<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentRemark extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'user_id',
        'call_outcome',
        'status',
        'remarks',
        'next_followup_at',
    ];

    protected function casts(): array
    {
        return [
            'next_followup_at' => 'datetime',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
