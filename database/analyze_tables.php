<?php

/**
 * Database Table Analysis Script
 * 
 * Run this to see which tables exist and which are actually being used
 * 
 * Usage: php database/analyze_tables.php
 */

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "\n";
echo "═══════════════════════════════════════════════════════════════════\n";
echo "                    DATABASE TABLE ANALYSIS                         \n";
echo "═══════════════════════════════════════════════════════════════════\n\n";

// Get all tables
$tables = DB::select('SHOW TABLES');
$dbName = DB::getDatabaseName();
$tableKey = "Tables_in_" . $dbName;

$allTables = array_map(function ($table) use ($tableKey) {
    return $table->$tableKey;
}, $tables);

sort($allTables);

echo "📊 Total Tables: " . count($allTables) . "\n\n";

// Categorize tables
$categories = [
    'Core Authentication & Users' => [
        'users',
        'password_reset_tokens',
        'personal_access_tokens',
        'sessions',
        'failed_jobs',
        'breezy_sessions'
    ],
    'Academic Structure (Faculties/Departments)' => [
        'sections',
        'certifications',
        'domains',
        'classrooms',
        'section_user',
        'certification_user',
        'classroom_user'
    ],
    'Assessment System' => [
        'assessments',
        'assessment_questions',
        'question_options',
        'assessment_attempts',
        'attempt_answers',
        'tests',
        'test_question',
        'quiz_headers',
        'quizzes',
        'quiz_answers',
        'my_quizzes',
        'quiz_section',
        'quiz_certification',
        'quiz_header_question'
    ],
    'Question Bank' => [
        'questions',
        'answers',
        'options'
    ],
    'Learning Materials' => [
        'hubs',
        'hub_user',
        'homework',
        'homework_submissions'
    ],
    'Permissions & Roles (Spatie)' => [
        'permissions',
        'roles',
        'model_has_permissions',
        'model_has_roles',
        'role_has_permissions'
    ],
    'Media & Files (Spatie)' => [
        'media'
    ],
    'System Features' => [
        'notifications',
        'quotes'
    ],
    'Gamification (Possibly Unused)' => [
        'achievements',
        'badges',
        'user_achievements',
        'user_badges',
        'leaderboards',
        'leaderboard_entries',
        'xp_transactions',
        'user_xps',
        'user_streaks'
    ],
    'Advanced Learning (Possibly Unused)' => [
        'flashcards',
        'flashcard_decks',
        'learning_paths',
        'subscriptions'
    ],
];

$categorizedTables = [];
$uncategorized = [];

foreach ($allTables as $table) {
    $found = false;
    foreach ($categories as $category => $tables) {
        if (in_array($table, $tables)) {
            $categorizedTables[$category][] = $table;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $uncategorized[] = $table;
    }
}

// Display categorized tables
foreach ($categories as $category => $expectedTables) {
    if (isset($categorizedTables[$category])) {
        $count = count($categorizedTables[$category]);
        $icon = strpos($category, 'Unused') !== false ? '❌' : '✅';

        echo "$icon $category ($count tables)\n";
        echo str_repeat('─', 67) . "\n";

        foreach ($categorizedTables[$category] as $table) {
            // Get row count
            try {
                $count = DB::table($table)->count();
                $status = $count > 0 ? "✓ $count rows" : "○ Empty";
            } catch (\Exception $e) {
                $status = "✗ Error";
            }

            echo sprintf("   %-35s %s\n", $table, $status);
        }
        echo "\n";
    }
}

if (!empty($uncategorized)) {
    echo "❓ Uncategorized Tables (" . count($uncategorized) . ")\n";
    echo str_repeat('─', 67) . "\n";
    foreach ($uncategorized as $table) {
        try {
            $count = DB::table($table)->count();
            $status = $count > 0 ? "✓ $count rows" : "○ Empty";
        } catch (\Exception $e) {
            $status = "✗ Error";
        }
        echo sprintf("   %-35s %s\n", $table, $status);
    }
    echo "\n";
}

// Summary
echo "═══════════════════════════════════════════════════════════════════\n";
echo "                           SUMMARY                                  \n";
echo "═══════════════════════════════════════════════════════════════════\n\n";

$coreTableCount = 0;
$gamificationCount = 0;

foreach ($categorizedTables as $category => $tables) {
    if (strpos($category, 'Unused') !== false || strpos($category, 'Gamification') !== false || strpos($category, 'Advanced Learning') !== false) {
        $gamificationCount += count($tables);
    } else {
        $coreTableCount += count($tables);
    }
}

echo "Core Application Tables:     $coreTableCount tables\n";
echo "Gamification/Extra Tables:   $gamificationCount tables\n";
echo "Uncategorized Tables:        " . count($uncategorized) . " tables\n";
echo "─────────────────────────────────────────────\n";
echo "TOTAL TABLES:                " . count($allTables) . " tables\n\n";

echo "💡 Recommendation for Presentation:\n";
echo "   Focus on the " . $coreTableCount . " core tables\n";
echo "   Mention the extra " . $gamificationCount . " tables as \"future enhancements\"\n\n";

echo "═══════════════════════════════════════════════════════════════════\n\n";
