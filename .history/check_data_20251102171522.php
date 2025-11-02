<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Question;
use App\Models\Test;

echo "=== Database Validation ===" . PHP_EOL;

// Check questions without correct answers
$badQuestions = Question::whereDoesntHave('answers', function ($q) {
    $q->where('is_checked', 1);
})->count();

echo "Questions without correct answer: " . $badQuestions . PHP_EOL;

// Check total questions
echo "Total questions: " . Question::count() . PHP_EOL;

// Check total tests
echo "Total tests: " . Test::count() . PHP_EOL;

// Check if tests have questions
$tests = Test::with('questions')->get();
foreach ($tests as $test) {
    echo "Test '{$test->name}': " . $test->questions->count() . " questions" . PHP_EOL;
}

echo PHP_EOL;
