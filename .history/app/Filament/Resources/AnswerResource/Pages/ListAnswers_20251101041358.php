<?php

namespace App\Filament\Resources\AnswerResource\Pages;

use App\Filament\Resources\AnswerResource;
use Filament\Resources\Pages\Page;
use App\Models\Question;

class ListAnswers extends Page
{
    protected static string $resource = AnswerResource::class;
    protected static string $view = 'filament.resources.answers.grouped';

    // Sorting & pagination state can be controlled via query string / form controls if needed
    protected int $perPage = 10;

    // Provide data to the blade safely (no public Livewire property for paginator)
    protected function getViewData(): array
    {
        // eager load answers and paginate; change perPage if you want different page size
        $questions = Question::with('answers')
            ->orderBy('question', 'asc')
            ->paginate($this->perPage);

        return [
            'questions' => $questions,
        ];
    }
}
