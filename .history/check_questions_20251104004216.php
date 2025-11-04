<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$assessments = DB::table('assessments')->select('id', 'title')->get();
echo 'Total assessments: ' . count($assessments) . PHP_EOL;

// Check if assessment 1 exists
$assessment1 = DB::table('assessments')->where('id', 1)->first();
if ($assessment1) {
    $questionCount1 = DB::table('assessment_questions')->where('assessment_id', 1)->count();
    echo 'Assessment 1: ' . $questionCount1 . ' questions - ' . $assessment1->title . PHP_EOL;
} else {
    echo 'Assessment 1 does not exist' . PHP_EOL;
}

foreach($assessments as $assessment) {
    $questionCount = DB::table('assessment_questions')->where('assessment_id', $assessment->id)->count();
    echo $assessment->id . ': ' . $questionCount . ' questions - ' . $assessment->title . PHP_EOL;
}