<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HomeworkSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'homework_id',
        'student_id',
        'submission_text',
        'submitted_files',
        'submitted_at',
        'score',
        'teacher_feedback',
        'graded_by',
        'graded_at',
        'status',
    ];

    protected $casts = [
        'submitted_files' => 'array',
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ];

    // Relationships
    public function homework(): BelongsTo
    {
        return $this->belongsTo(Homework::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    // Helper methods
    public function isLate(): bool
    {
        if (!$this->submitted_at || !$this->homework) {
            return false;
        }
        return $this->submitted_at->gt($this->homework->due_date);
    }

    public function isGraded(): bool
    {
        return $this->status === 'graded';
    }

    public function canBeGraded(): bool
    {
        return $this->status === 'submitted' || $this->status === 'late';
    }
}
