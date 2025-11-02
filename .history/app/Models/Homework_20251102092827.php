<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Homework extends Model
{
    use HasFactory;

    protected $table = 'homework';

    protected $fillable = [
        'title',
        'description',
        'instructions',
        'teacher_id',
        'certification_id',
        'section_id',
        'classroom_id',
        'assigned_date',
        'due_date',
        'max_points',
        'attachments',
        'allow_late_submission',
        'is_published',
    ];

    protected $casts = [
        'attachments' => 'array',
        'assigned_date' => 'date',
        'due_date' => 'datetime',
        'allow_late_submission' => 'boolean',
        'is_published' => 'boolean',
    ];

    // Relationships
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(HomeworkSubmission::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'homework_submissions', 'homework_id', 'student_id');
    }

    // Helper methods
    public function isOverdue(): bool
    {
        return now()->gt($this->due_date);
    }

    public function submissionRate(): float
    {
        $total = $this->submissions()->count();
        $submitted = $this->submissions()->where('status', '!=', 'not_submitted')->count();
        return $total > 0 ? ($submitted / $total) * 100 : 0;
    }

    public function gradingProgress(): float
    {
        $total = $this->submissions()->where('status', '!=', 'not_submitted')->count();
        $graded = $this->submissions()->where('status', 'graded')->count();
        return $total > 0 ? ($graded / $total) * 100 : 0;
    }
}
