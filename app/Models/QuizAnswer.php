<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_header_id',
        'question_id',
        'answer_id',
        'is_correct',
    ];

    public function quizHeader()
    {
        return $this->belongsTo(QuizHeader::class);
    }
}
