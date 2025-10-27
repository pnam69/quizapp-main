<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Certification;
use App\Models\Question;

class Test extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'certification_id', 'question_ids', 'is_active'];

    protected $casts = ['question_ids' => 'array'];

    public function certification(): BelongsTo {
        return $this->belongsTo(Certification::class);
    }
    public function getNewQuestion()
{
    $test = \App\Models\Test::find($this->currentquizHeader->test_id);

    $nextIndex = count($this->answeredQuestions);

    if ($nextIndex >= count($test->question_ids)) {
        $this->showResults();
        return null;
    }

    $nextQuestionId = $test->question_ids[$nextIndex];
    $question = Question::with('answers')->find($nextQuestionId);

    if ($question) {
        $this->answeredQuestions[] = $question->id;
    }

    return $question;
}

    public function questions(): HasMany {
        return $this->hasMany(Question::class, 'id', 'question_ids');
    }
}
