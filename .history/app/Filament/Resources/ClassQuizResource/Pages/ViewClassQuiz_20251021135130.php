<?php

namespace App\Filament\Resources\ClassQuizResource\Pages;

use App\Filament\Resources\ClassQuizResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\QuizHeader;

\App\Models\Classroom::create(['name' => 'Class A']);
\App\Models\Classroom::create(['name' => 'Class B']);

\App\Models\User::create(['name' => 'Alice', 'email' => 'alice@example.com', 'password' => bcrypt('password'), 'classroom_id' => 1]);
\App\Models\User::create(['name' => 'Bob', 'email' => 'bob@example.com', 'password' => bcrypt('password'), 'classroom_id' => 1]);
\App\Models\User::create(['name' => 'Charlie', 'email' => 'charlie@example.com', 'password' => bcrypt('password'), 'classroom_id' => 2]);

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