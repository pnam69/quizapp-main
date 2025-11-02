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
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->foreignId('test_id')->nullable()->constrained()->onDelete('cascade')->after('user_id');
            $table->integer('current_index')->nullable()->after('learningmode');
            $table->timestamp('started_at')->nullable()->after('current_index');
            $table->timestamp('finished_at')->nullable()->after('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->dropForeign(['test_id']);
            $table->dropColumn(['test_id', 'current_index', 'started_at', 'finished_at']);
        });
    }
};
