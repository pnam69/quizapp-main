<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$permissions = DB::table('permissions')
    ->where(function($query) {
        $query->where('name', 'like', '%achievement%')
              ->orWhere('name', 'like', '%badge%')
              ->orWhere('name', 'like', '%leaderboard%')
              ->orWhere('name', 'like', '%flashcard%')
              ->orWhere('name', 'like', '%learning_path%');
    })
    ->get(['id', 'name']);

if ($permissions->count() > 0) {
    echo "Found " . $permissions->count() . " old permissions:\n";
    foreach ($permissions as $permission) {
        echo "  - {$permission->name} (ID: {$permission->id})\n";
    }
    echo "\nThese should be deleted.\n";
} else {
    echo "No old permissions found. ✓\n";
}
