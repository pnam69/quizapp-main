<?php

namespace App\Filament\Resources\AnswerResource\Pages;

use App\Filament\Resources\AnswerResource;
use Filament\Resources\Pages\Page;

class ListAnswers extends Page
{
    protected static string $resource = AnswerResource::class;
    protected static string $view = 'filament.resources.answers.grouped';

    public $questions;
    public function render(): View
    {
        return view('filament.resources.answers.grouped', [
            'answers' => $this->getAnswers(), // or whatever data you pass
        ]);
    }

    public function mount(): void
    {
        // Load questions with their answers
        $this->questions = \App\Models\Question::with('answers')->get();
    }
    
}
