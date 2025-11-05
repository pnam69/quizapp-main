<?php

require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$user = App\Models\User::find(21);
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
    ->where('status', 'completed')
    ->get();

echo 'Completed attempts for available assessments: ' . $attempts->count() . PHP_EOL;
$percentages = $attempts->pluck('percentage');
echo 'Percentages: ' . $percentages->join(', ') . PHP_EOL;
echo 'Average: ' . $percentages->average() . PHP_EOL;