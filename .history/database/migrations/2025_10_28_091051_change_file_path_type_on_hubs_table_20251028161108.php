<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('hubs', function (Blueprint $table) {
            // change column to JSON nullable
            $table->json('file_path')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('hubs', function (Blueprint $table) {
            $table->longText('file_path')->nullable()->change();
        });
    }
};
