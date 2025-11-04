<?php
require_once 'vendor/autoload.php';
require_once 'bootstrap/app.php';

$assessments = DB::table('assessments')->select('id', 'title')->get();
foreach($assessments as $assessment) {
    $questionCount = DB::table('assessment_questions')->where('assessment_id', $assessment->id)->count();
    echo $assessment->id . ': ' . $questionCount . ' questions - ' . $assessment->title . PHP_EOL;
}