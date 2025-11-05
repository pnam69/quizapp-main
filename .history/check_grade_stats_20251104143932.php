<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== STUDENT GRADES STATISTICS ===\n\n";

$totalAttempts = DB::table('assessment_attempts')->where('status', 'completed')->count();
$passed = DB::table('assessment_attempts')->where('status', 'completed')->where('passed', true)->count();
$failed = DB::table('assessment_attempts')->where('status', 'completed')->where('passed', false)->count();
$excellent = DB::table('assessment_attempts')->where('status', 'completed')->where('percentage', '>=', 80)->count();
$needsImprovement = DB::table('assessment_attempts')->where('status', 'completed')->where('percentage', '<', 60)->count();

$avgScore = DB::table('assessment_attempts')->where('status', 'completed')->avg('percentage');
$passRate = ($passed / $totalAttempts) * 100;

echo "All Grades: $totalAttempts\n";
echo "Passed: $passed (" . round(($passed/$totalAttempts)*100, 1) . "%)\n";
echo "Failed: $failed (" . round(($failed/$totalAttempts)*100, 1) . "%)\n";
echo "Excellent (≥80%): $excellent (" . round(($excellent/$totalAttempts)*100, 1) . "%)\n";
echo "Needs Improvement (<60%): $needsImprovement (" . round(($needsImprovement/$totalAttempts)*100, 1) . "%)\n\n";

echo "Average Score: " . round($avgScore, 1) . "%\n";
echo "Pass Rate: " . round($passRate, 1) . "%\n\n";

// Show score distribution
echo "=== SCORE DISTRIBUTION ===\n";
$ranges = [
    '90-100%' => DB::table('assessment_attempts')->whereBetween('percentage', [90, 100])->count(),
    '80-89%' => DB::table('assessment_attempts')->whereBetween('percentage', [80, 89.99])->count(),
    '70-79%' => DB::table('assessment_attempts')->whereBetween('percentage', [70, 79.99])->count(),
    '60-69%' => DB::table('assessment_attempts')->whereBetween('percentage', [60, 69.99])->count(),
    '50-59%' => DB::table('assessment_attempts')->whereBetween('percentage', [50, 59.99])->count(),
    '<50%' => DB::table('assessment_attempts')->where('percentage', '<', 50)->count(),
];

foreach ($ranges as $range => $count) {
    $percentage = round(($count / $totalAttempts) * 100, 1);
    echo "$range: $count ({$percentage}%)\n";
}