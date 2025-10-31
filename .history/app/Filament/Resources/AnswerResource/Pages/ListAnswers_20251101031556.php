<?php

namespace App\Filament\Resources\AnswerResource\Pages;

use App\Filament\Resources\AnswerResource;
use Filament\Resources\Pages\Page;
use App\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;

class ListAnswers extends Page
{
    protected static string $resource = AnswerResource::class;
    protected static string $view = 'filament.resources.answers.grouped';

    public $questions;
    public $perPage = 10;
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
        $query = Question::with('answers')->orderBy('id', 'asc');

        $total = $query->count();
        $items = $query->forPage($this->page, $this->perPage)->get();

        $this->questions = new LengthAwarePaginator(
            $items,
            $total,
            $this->perPage,
            $this->page
        );
    }

    public function nextPage(): void
    {
        if ($this->page < $this->questions->lastPage()) {
            $this->page++;
            $this->loadQuestions();
        }
    }

    public function prevPage(): void
    {
        if ($this->page > 1) {
            $this->page--;
            $this->loadQuestions();
        }
    }
}
