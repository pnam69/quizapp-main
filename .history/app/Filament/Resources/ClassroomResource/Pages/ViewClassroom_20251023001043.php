<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Resources\ClassroomResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\QuizHeader;

class ViewClassroom extends ViewRecord
{
    protected static string $resource = ClassroomResource::class;

    public function getQuizzesTaken()
    {
        return QuizHeader::where('classroom_id', $this->record->id)
            ->with('quiz')
            ->get()
            ->groupBy('quiz_id');
    }

    public function getQuizResultsUrl(int $quizId): string
    {
        return url("/admin/classroom-quiz-results/{$this->record->id}/{$quizId}");
    }
}