<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// QuizAnswer.php
class QuizAnswer extends Model
{
    protected $fillable = ['user_id', 'quiz_header_id', 'question_id', 'option_id', 'is_correct'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
