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
    public $page = 1;
    public $perPage = 10; // 10 questions per page
    public $totalPages;

    public function mount(): void
    {
        $allQuestions = Question::with('answers')->get();
        $this->totalPages = ceil($allQuestions->count() / $this->perPage);
        $this->questions = $allQuestions->forPage($this->page, $this->perPage);
    }

    public function goToPage($page): void
    {
        $allQuestions = Question::with('answers')->get();
        $this->page = max(1, min($page, ceil($allQuestions->count() / $this->perPage)));
        $this->questions = $allQuestions->forPage($this->page, $this->perPage);
    }
    public function previousPage(): void
    {
        if ($this->page > 1) {
            $this->page--;
            $this->loadQuestions();
        }
    }

    public function nextPage(): void
    {
        if ($this->page < $this->totalPages) {
            $this->page++;
            $this->loadQuestions();
        }
    }

    protected function loadQuestions(): void
    {
        $this->totalPages = ceil(\App\Models\Question::count() / $this->perPage);

        $this->questions = \App\Models\Question::with('answers')
            ->skip(($this->page - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();
    }
}
