<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassQuiz extends Model
{
    protected $fillable = ['classroom_id', 'quiz_id'];

    public function classroom()
    {
        return $this->belongsTo(ClassCourse::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}