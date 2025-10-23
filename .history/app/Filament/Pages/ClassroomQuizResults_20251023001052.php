<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\QuizHeader;

class ClassroomQuizResults extends Page
{
    protected static string $view = 'filament.pages.classroom-quiz-results';
    protected static ?string $navigationIcon = null;
    protected static ?string $route = '/classroom-quiz-results/{classroom}/{quiz}';

    public $classroomId;
    public $quizId;
    public $results;

    public function mount($classroom, $quiz): void
    {
        $this->classroomId = (int) $classroom;
        $this->quizId = (int) $quiz;

        $this->results = QuizHeader::with('user')
            ->where('classroom_id', $this->classroomId)
            ->where('quiz_id', $this->quizId)
            ->get();
    }
}