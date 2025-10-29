<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Adjust quiz_section table
        Schema::table('quiz_section', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_section', 'quiz_id')) {
                $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            }
            if (!Schema::hasColumn('quiz_section', 'section_id')) {
                $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            }
        });

        // Adjust quiz_certification table
        Schema::table('quiz_certification', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_certification', 'quiz_id')) {
                $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
            }
            if (!Schema::hasColumn('quiz_certification', 'certification_id')) {
                $table->foreignId('certification_id')->constrained('certifications')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quiz_section', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
            $table->dropForeign(['section_id']);
        });

        Schema::table('quiz_certification', function (Blueprint $table) {
            $table->dropForeign(['quiz_id']);
            $table->dropForeign(['certification_id']);
        });
    }
};
