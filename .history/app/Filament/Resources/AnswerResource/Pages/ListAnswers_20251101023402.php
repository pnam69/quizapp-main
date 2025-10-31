<?php

namespace App\Filament\Resources\AnswerResource\Pages;

use App\Filament\Resources\AnswerResource;
use Filament\Resources\Pages\Page;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Question;

class ListAnswers extends Page
{
    protected static string $resource = AnswerResource::class;
    protected static string $view = 'filament.resources.answers.grouped';

    public $sortBy = 'question'; // default sort column
    public $sortDirection = 'asc'; // default sort direction
    public $perPage = 10; // items per page

    // Livewire will handle $page automatically for pagination
    public $page = 1;

    public $questions;

    public function mount(): void
    {
        $this->loadQuestions();
    }

    public function updatedSortBy(): void
    {
        $this->page = 1; // reset to first page on sorting change
        $this->loadQuestions();
    }

    public function updatedSortDirection(): void
    {
        $this->page = 1;
        $this->loadQuestions();
    }

    public function updatedPage(): void
    {
        $this->loadQuestions();
    }

    protected function loadQuestions(): void
    {
        // Use database pagination to avoid loading everything into memory
        $this->questions = Question::with('answers')
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate($this->perPage, ['*'], 'page', $this->page);
    }

    // Optional: method to toggle sort direction
    public function toggleSort(): void
    {
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        $this->page = 1;
        $this->loadQuestions();
    }
}
