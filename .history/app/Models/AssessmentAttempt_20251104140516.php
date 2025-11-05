<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'user_id',
        'attempt_number',
        'started_at',
        'submitted_at',
        'time_taken',
        'score',
        'points_earned',
        'total_points',
        'percentage',
        'passed',
        'status',
        'answers',
    ];

    protected $casts = [
        'answers' => 'array',
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'passed' => 'boolean',
        'points_earned' => 'integer',
        'total_points' => 'integer',
    ];

    // Relationships
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attemptAnswers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class, 'attempt_id');
    }

    // Helper methods
    public function calculateResults()
    {
        $this->points_earned = $this->attemptAnswers()->sum('points_earned');
        $this->total_points = $this->assessment->total_points;
        $this->percentage = $this->total_points > 0
            ? round(($this->points_earned / $this->total_points) * 100, 2)
            : 0.00;
        $this->score = $this->percentage;
        $this->passed = $this->percentage >= $this->assessment->passing_score;
        $this->save();
    }

    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
