<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'section_id',
        'certification_id',
        'domains',
        'completed',
        'quiz_size',
        'questions_taken',
        'score',
        'difficulty',
        'learningmode',
        'test_id',         // added
        'current_index',   // added
        'started_at',
        'finished_at',
    ];

    protected $casts = [
        'domains' => 'array',
        'questions_taken' => 'array',
        'difficulty' => 'array',
        'current_index' => 'integer', // added
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_header_question');
    }


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }
    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'quiz_header_question');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(QuizAnswer::class, 'quiz_header_id');
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
