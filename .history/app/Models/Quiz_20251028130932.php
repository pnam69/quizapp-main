<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quiz_header_id',
        'section_id',
        'certification_id',
        'domain_id',
        'question_id',
        'answer_id',
        'is_correct',
    ];

    // Single belongsTo relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiz_header()
    {
        return $this->belongsTo(QuizHeader::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }

    public function domain()
    {
        return $this->belongsTo(Domain::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    // Many-to-many relationships
    public function sections()
    {
        return $this->belongsToMany(Section::class, 'quiz_section', 'quiz_id', 'section_id');
    }

    public function certifications()
    {
        return $this->belongsToMany(Certification::class, 'quiz_certification', 'quiz_id', 'certification_id');
    }
}
