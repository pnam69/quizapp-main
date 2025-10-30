<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MyQuizzes extends Model
{
    use HasFactory;
    protected $table = 'my_quizzes';


    protected $casts = [
        'domains' => 'array',
        'questions_taken' => 'array',
        'difficulty' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($quiz) {
            $quiz->user_id = auth()->id();
            $quiz->link_token = \Str::uuid();
        });
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
    public function section(): BelongsTo {
        return $this->belongsTo(Section::class);
    }
    public function certification(): BelongsTo {
        return $this->belongsTo(Certification::class);
    }

    public function quizzes(): HasMany {
        return $this->hasMany(Quiz::class);
    }


}
