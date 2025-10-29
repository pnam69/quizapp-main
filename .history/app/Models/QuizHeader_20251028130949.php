<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sections',         // json array if stored as IDs
        'certifications',   // json array if stored as IDs
        'domains',
        'completed',
        'quiz_size',
        'questions_taken',
        'score',
        'difficulty',
        'learningmode',
    ];

    protected $casts = [
        'sections' => 'array',
        'certifications' => 'array',
        'domains' => 'array',
        'questions_taken' => 'array',
        'difficulty' => 'array',
        'completed' => 'boolean',
        'learningmode' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
