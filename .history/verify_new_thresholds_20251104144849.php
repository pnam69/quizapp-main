<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\AssessmentAttempt;

echo "\n=== GRADE DISTRIBUTION WITH NEW THRESHOLDS ===\n";
echo "Passed: ≥70% | Needs Improvement: 50-69% | Failed: <50%\n";
echo "===========================================\n\n";

$attempts = AssessmentAttempt::where('status', 'completed')->get();

$total = $attempts->count();
$passed = $attempts->where('percentage', '>=', 70)->count();
$needsImprovement = $attempts->whereBetween('percentage', [50, 69.99])->count();
$failed = $attempts->where('percentage', '<', 50)->count();

echo "Total Attempts: {$total}\n";
echo "\n";

// Main categories
echo "PASSED (≥70%):           {$passed} (" . round($passed/$total*100, 1) . "%)\n";
echo "NEEDS IMPROVEMENT (50-69%): {$needsImprovement} (" . round($needsImprovement/$total*100, 1) . "%)\n";
echo "FAILED (<50%):           {$failed} (" . round($failed/$total*100, 1) . "%)\n";
echo "\n";

// Detailed breakdown
echo "--- Detailed Breakdown ---\n";
$ranges = [
    '90-100%' => $attempts->where('percentage', '>=', 90)->count(),
    '80-89%' => $attempts->whereBetween('percentage', [80, 89.99])->count(),
    '70-79%' => $attempts->whereBetween('percentage', [70, 79.99])->count(),
    '60-69%' => $attempts->whereBetween('percentage', [60, 69.99])->count(),
    '50-59%' => $attempts->whereBetween('percentage', [50, 59.99])->count(),
    '40-49%' => $attempts->whereBetween('percentage', [40, 49.99])->count(),
    '<40%' => $attempts->where('percentage', '<', 40)->count(),
];

foreach ($ranges as $range => $count) {
    $percentage = round($count/$total*100, 1);
    echo "{$range}: {$count} ({$percentage}%)\n";
}

echo "\n";
echo "Average Score: " . round($attempts->avg('percentage'), 1) . "%\n";
echo "\n===========================================\n";
