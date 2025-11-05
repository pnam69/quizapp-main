<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::find(21);
echo 'User 21 sections: ' . $user->sections->pluck('id')->join(', ') . PHP_EOL;
echo 'User 21 classrooms: ' . $user->classrooms->pluck('id')->join(', ') . PHP_EOL;

$sectionIds = $user->sections->pluck('id');
$classroomIds = $user->classrooms->pluck('id');

$assessments = App\Models\Assessment::where(function ($query) use ($sectionIds, $classroomIds) {
    $query->whereIn('section_id', $sectionIds)
        ->orWhereIn('classroom_id', $classroomIds);
})->where('is_published', true)
  ->where('is_active', true)
  ->get();

echo 'Available assessments for user 21: ' . $assessments->count() . PHP_EOL;
$assessments->each(function($a) {
    echo '- ' . $a->title . ' (ID: ' . $a->id . ')' . PHP_EOL;
});

$attempts = App\Models\AssessmentAttempt::where('user_id', 21)
    ->whereIn('assessment_id', $assessments->pluck('id'))
    ->get();

echo 'All attempts for available assessments: ' . $attempts->count() . PHP_EOL;
$attempts->each(function($attempt) {
    echo '- Assessment ID: ' . $attempt->assessment_id . ', Status: ' . $attempt->status . ', Percentage: ' . ($attempt->percentage ?? 'NULL') . PHP_EOL;
});

$completedAttempts = $attempts->where('status', 'completed');
echo 'Completed attempts: ' . $completedAttempts->count() . PHP_EOL;
$percentages = $completedAttempts->pluck('percentage');
echo 'Percentages: ' . $percentages->join(', ') . PHP_EOL;
if ($percentages->count() > 0) {
    echo 'Average: ' . $percentages->average() . PHP_EOL;
} else {
    echo 'No completed attempts to average' . PHP_EOL;
}