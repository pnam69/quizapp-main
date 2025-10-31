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
    public $perPage = 10;

    public function mount(): void
    {
        $this->loadQuestions();
    }

    public function loadQuestions(): void
    {
        $this->questions = Question::with('answers')->paginate($this->perPage);
    }

    public function updatedPage($value): void
    {
        $this->loadQuestions();
    }
}
