<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('xp_transactions', function (Blueprint $table) {
            $table->string('type')->nullable()->after('amount'); // quiz_completion, streak_bonus, etc.
            $table->json('metadata')->nullable()->after('description'); // Additional data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('xp_transactions', function (Blueprint $table) {
            $table->dropColumn(['type', 'metadata']);
        });
    }
};
