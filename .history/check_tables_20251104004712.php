<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TABLES WITH 'QUESTION' IN NAME ===\n";
$tables = DB::select('SHOW TABLES');
foreach($tables as $table) {
    $name = array_values((array)$table)[0];
    if(strpos($name, 'question') !== false) {
        echo $name . "\n";
    }
}

echo "\n=== ALL TABLES ===\n";
foreach($tables as $table) {
    $name = array_values((array)$table)[0];
    echo $name . "\n";
}