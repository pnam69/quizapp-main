<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MyQuizzes extends Model
{
    use HasFactory;

    protected $table = 'my_quizzes';

    protected $fillable = [
        'title',
        'description',
        'questions',
        'user_id',
        'link_token',
        'public',
    ];

    protected $casts = [
        'questions' => 'array',
        'public' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($quiz) {
            // Only set user_id if not already assigned
            if (! $quiz->user_id && Auth::check()) {
                $quiz->user_id = Auth::id();
            }

            // Always set a unique token
            if (! $quiz->link_token) {
                $quiz->link_token = (string) Str::uuid();
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the number of questions in this quiz
     */
    public function getQuestionCountAttribute(): int
    {
        return $this->questions ? count($this->questions) : 0;
    }
}
