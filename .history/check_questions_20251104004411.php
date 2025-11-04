<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== OLD QUIZ HEADERS (47 total) ===\n";
$oldQuizzes = DB::table('quiz_headers')->select('id', 'title', 'completed')->take(10)->get();
foreach($oldQuizzes as $quiz) {
    echo $quiz->id . ': ' . $quiz->title . ' (completed: ' . $quiz->completed . ')' . PHP_EOL;
}

echo "\n=== NEW ASSESSMENTS (4 total) ===\n";
$assessments = DB::table('assessments')->select('id', 'title')->get();
foreach($assessments as $assessment) {
    $questionCount = DB::table('assessment_questions')->where('assessment_id', $assessment->id)->count();
    echo $assessment->id . ': ' . $questionCount . ' questions - ' . $assessment->title . PHP_EOL;
}