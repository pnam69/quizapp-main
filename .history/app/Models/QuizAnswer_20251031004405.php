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
        'option_id',
        'is_correct',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function quizHeader()
    {
        return $this->belongsTo(QuizHeader::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
