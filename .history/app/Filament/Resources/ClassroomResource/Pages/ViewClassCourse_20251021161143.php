<?php

namespace App\Filament\Resources\ClassroomResource\Pages;

use App\Filament\Resources\ClassroomResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\QuizHeader;

class ViewClassroom extends ViewRecord
{
    protected static string $resource = ClassCourseResource::class;

    public function getQuizzesTaken()
    {
        // Get all quizzes taken by this class
        return QuizHeader::where('class_course_id', $this->record->id)
            ->with('quiz')
            ->get()
            ->groupBy('quiz_id');
    }
}
