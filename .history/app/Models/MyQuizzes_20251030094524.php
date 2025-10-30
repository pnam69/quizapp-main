<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class MyQuizzes extends Model
{
    use HasFactory;

    protected $table = 'quiz_headers';

    protected $fillable = [
        'title',
        'description',
        'section_id',
        'certification_id',
        'domains',
        'questions_taken',
        'difficulty',
        'user_id',
        'link_token',
    ];

    protected $casts = [
        'domains' => 'array',
        'questions_taken' => 'array',
        'difficulty' => 'array',
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

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function certification(): BelongsTo
    {
        return $this->belongsTo(Certification::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'quiz_header_id');
    }
}

    public function quizzes(): HasMany {
        return $this->hasMany(Quiz::class);
    }


}
