<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== STUDENT GRADES TABLE SAMPLE ===\n";
$attempts = DB::table('assessment_attempts')
    ->join('users', 'assessment_attempts.user_id', '=', 'users.id')
    ->join('assessments', 'assessment_attempts.assessment_id', '=', 'assessments.id')
    ->select('users.name as student_name', 'assessments.title as assessment_title', 'assessment_attempts.percentage', 'assessment_attempts.passed', 'assessment_attempts.submitted_at')
    ->where('assessment_attempts.status', 'completed')
    ->orderBy('assessment_attempts.submitted_at', 'desc')
    ->take(10)
    ->get();

foreach($attempts as $attempt) {
    $status = $attempt->passed ? 'PASSED' : 'FAILED';
    echo $attempt->student_name . ' - ' . $attempt->assessment_title . ': ' . $attempt->percentage . '% (' . $status . ")\n";
}

echo "\n=== SUMMARY STATISTICS ===\n";
$totalAttempts = DB::table('assessment_attempts')->where('status', 'completed')->count();
$totalStudents = DB::table('assessment_attempts')->distinct('user_id')->count('user_id');
$totalAssessments = DB::table('assessment_attempts')->distinct('assessment_id')->count('assessment_id');
$avgScore = DB::table('assessment_attempts')->where('status', 'completed')->avg('percentage');
$passRate = DB::table('assessment_attempts')->where('status', 'completed')->where('passed', true)->count() / $totalAttempts * 100;

echo "Total Attempts: $totalAttempts\n";
echo "Total Students: $totalStudents\n";
echo "Total Assessments: $totalAssessments\n";
echo "Average Score: " . round($avgScore, 1) . "%\n";
echo "Pass Rate: " . round($passRate, 1) . "%\n";