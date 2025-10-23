<?php

namespace App\Filament\Resources\ClassQuizResource\Pages;

use App\Filament\Resources\ClassQuizResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\QuizHeader;


class ViewClassQuiz extends ViewRecord
{
    
    protected static string $resource = ClassQuizResource::class;

    public function getStudentScores()
    {
        $students = $this->record->classroom->users;

        return $students->map(function ($student) {
            $quizHeader = QuizHeader::where('user_id', $student->id)
                ->where('quiz_id', $this->record->quiz_id)
                ->first();

            return [
                'name' => $student->name,
                'score' => $quizHeader ? $quizHeader->score : 'N/A',
            ];
        });
    }
}