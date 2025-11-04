<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'time_limit',
        'passing_score',
        'attempts_allowed',
        'shuffle_questions',
        'shuffle_options',
        'show_correct_answers',
        'teacher_id',
        'classroom_id',
        'section_id',
        'certification_id',
        'available_from',
        'available_until',
        'is_published',
        'is_active',
        'difficulty',
        'category',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'shuffle_questions' => 'boolean',
        'shuffle_options' => 'boolean',
        'show_correct_answers' => 'boolean',
        'is_published' => 'boolean',
        'is_active' => 'boolean',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
    ];

    // Relationships
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class)->orderBy('order');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(AssessmentAttempt::class);
    }

    // Helper methods
    public function getTotalPointsAttribute(): int
    {
        // Check if questions are already loaded (eager loading)
        if ($this->relationLoaded('questions')) {
            return $this->questions->sum('points');
        }
        return $this->questions()->sum('points');
    }

    public function getTotalQuestionsAttribute(): int
    {
        // Check if questions are already loaded (eager loading)
        if ($this->relationLoaded('questions')) {
            return $this->questions->count();
        }
        return $this->questions()->count();
    }

    public function isAvailable(): bool
    {
        if (!$this->is_published || !$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->available_from && $now->lt($this->available_from)) {
            return false;
        }

        if ($this->available_until && $now->gt($this->available_until)) {
            return false;
        }

        return true;
    }

    public function canUserAttempt(User $user): bool
    {
        if (!$this->isAvailable()) {
            return false;
        }

        // If attempts_allowed is null or -1, unlimited attempts
        if ($this->attempts_allowed === null || $this->attempts_allowed == -1) {
            return true;
        }

        $userAttempts = $this->attempts()
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        return $userAttempts < $this->attempts_allowed;
    }
}
