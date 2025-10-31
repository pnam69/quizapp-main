<?php

namespace App\Filament\Resources\AnswerResource\Pages;

use App\Filament\Resources\AnswerResource;
use Filament\Resources\Pages\Page;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Models\Answer;

class ListAnswers extends Page
{
    protected static string $resource = AnswerResource::class;
    protected static string $view = 'filament.resources.answers.grouped';

    public $questions;
    public $sortBy = 'question'; // default sort
    public $perPage = 10; // items per page
    public $page = 1;

    public function mount(): void
    {
        $this->loadQuestions();
    }

    public function updatedSortBy(): void
    {
        $this->loadQuestions();
    }

    public function updatedPage(): void
    {
        $this->loadQuestions();
    }

    protected function loadQuestions(): void
    {
        $allQuestions = \App\Models\Question::with('answers')
            ->orderBy($this->sortBy)
            ->get();

        // Simple pagination
        $currentPage = $this->page;
        $perPage = $this->perPage;
        $items = $allQuestions->forPage($currentPage, $perPage);

        $this->questions = new LengthAwarePaginator(
            $items,
            $allQuestions->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );
    }
}
