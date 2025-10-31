<?php

namespace App\Filament\Resources\AnswerResource\Pages;

use App\Filament\Resources\AnswerResource;
use Filament\Resources\Pages\Page;
use App\Models\Question;

class ListAnswers extends Page
{
    protected static string $resource = AnswerResource::class;
    protected static string $view = 'filament.resources.answers.grouped';

    public $questions;
    public $perPage = 5; // number of questions per page

    // Filament will automatically handle the current page if you use query params
    public $page = 1;

    public function mount(): void
    {
        $this->loadQuestions();
    }

    public function updatedPage(): void
    {
        $this->loadQuestions();
    }

    protected function loadQuestions(): void
    {
        $this->questions = Question::with('answers')
            ->paginate($this->perPage, ['*'], 'page', $this->page);
    }
}
