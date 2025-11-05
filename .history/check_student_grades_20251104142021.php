<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== STUDENT GRADES CHECK ===\n";
$attempts = DB::table('assessment_attempts')
    ->join('users', 'assessment_attempts.user_id', '=', 'users.id')
    ->join('assessments', 'assessment_attempts.assessment_id', '=', 'assessments.id')
    ->where('assessment_attempts.status', 'completed')
    ->select('assessment_attempts.*', 'users.name as user_name', 'assessments.title as assessment_title')
    ->take(5)
    ->get();

foreach($attempts as $attempt) {
    echo $attempt->user_name . ' - ' . $attempt->assessment_title . ': ' . $attempt->percentage . "% (Score: " . $attempt->score . ")\n";
}