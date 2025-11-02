<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'question_text',
        'question_type',
        'points',
        'order',
        'image_url',
        'explanation',
        'is_required',
    ];

    protected $casts = [
        'is_required' => 'boolean',
    ];

    // Relationships
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class, 'question_id')->orderBy('order');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class, 'question_id');
    }

    // Helper methods
    public function getCorrectOption()
    {
        return $this->options()->where('is_correct', true)->first();
    }

    public function getCorrectOptions()
    {
        return $this->options()->where('is_correct', true)->get();
    }
}
