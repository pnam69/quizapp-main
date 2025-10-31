<?php
// AnswerResource\Pages\ListAnswers.php

use App\Models\Answer;

class ListAnswers extends ListRecords
{
    public function render()
    {
        // You can add filters/sorting here
        $answers = Answer::with('question')->paginate(10);

        return view('filament.resources.answers.pages.list-answers', [
            'answers' => $answers,
        ]);
    }
}
