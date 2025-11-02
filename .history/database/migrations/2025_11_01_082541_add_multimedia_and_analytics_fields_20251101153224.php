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
        // Add multimedia support to questions (if columns don't exist)
        if (!Schema::hasColumn('questions', 'question_media')) {
            Schema::table('questions', function (Blueprint $table) {
                $table->string('question_media')->nullable()->after('question');
                $table->string('question_media_type')->nullable()->after('question_media');
                $table->string('difficulty')->default('medium')->after('explanation');
                $table->integer('time_limit_seconds')->nullable()->after('difficulty');
                $table->json('tags')->nullable()->after('time_limit_seconds');
            });
        }

        // Add multimedia to answers (if columns don't exist)
        if (!Schema::hasColumn('answers', 'answer_media')) {
            Schema::table('answers', function (Blueprint $table) {
                $table->string('answer_media')->nullable()->after('answer');
                $table->string('answer_media_type')->nullable()->after('answer_media');
            });
        }

        // Enhanced quiz analytics (if columns don't exist)
        if (!Schema::hasColumn('quiz_headers', 'average_score')) {
            Schema::table('quiz_headers', function (Blueprint $table) {
                $table->integer('average_score')->nullable()->after('quiz_size');
                $table->integer('completion_rate')->nullable()->after('average_score');
                $table->integer('total_attempts')->default(0)->after('completion_rate');
                $table->integer('average_time_seconds')->nullable()->after('total_attempts');
            });
        }

        // Enhanced quiz answer tracking (if columns don't exist)
        if (!Schema::hasColumn('quiz_answers', 'time_taken_seconds')) {
            Schema::table('quiz_answers', function (Blueprint $table) {
                $table->integer('time_taken_seconds')->nullable()->after('is_correct');
                $table->timestamp('started_at')->nullable()->after('time_taken_seconds');
                $table->timestamp('submitted_at')->nullable()->after('started_at');
            });
        }

        // Add offline support tracking
        if (!Schema::hasTable('offline_content')) {
            Schema::create('offline_content', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->string('content_type');
                $table->foreignId('content_id');
                $table->boolean('is_downloaded')->default(false);
                $table->timestamp('downloaded_at')->nullable();
                $table->timestamp('last_synced_at')->nullable();
                $table->bigInteger('file_size')->nullable();
                $table->timestamps();
                
                $table->index(['user_id', 'content_type']);
            });
        }

        // Teacher-specific analytics
        if (!Schema::hasTable('teacher_analytics')) {
            Schema::create('teacher_analytics', function (Blueprint $table) {
                $table->id();
                $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('classroom_id')->nullable()->constrained()->nullOnDelete();
                $table->date('date');
                $table->integer('active_students')->default(0);
                $table->integer('quizzes_assigned')->default(0);
                $table->integer('quizzes_completed')->default(0);
                $table->decimal('average_class_score', 5, 2)->nullable();
                $table->integer('total_study_hours')->default(0);
                $table->json('top_performers')->nullable();
                $table->json('struggling_students')->nullable();
                $table->timestamps();
                
                $table->index(['teacher_id', 'date']);
            });
        }

        // Question difficulty tracking
        if (!Schema::hasTable('question_statistics')) {
            Schema::create('question_statistics', function (Blueprint $table) {
                $table->id();
                $table->foreignId('question_id')->constrained()->cascadeOnDelete();
                $table->integer('total_attempts')->default(0);
                $table->integer('correct_attempts')->default(0);
                $table->decimal('difficulty_score', 5, 2)->default(50);
                $table->integer('average_time_seconds')->nullable();
                $table->decimal('discrimination_index', 5, 2)->nullable();
                $table->timestamps();
                
                $table->unique('question_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_statistics');
        Schema::dropIfExists('teacher_analytics');
        Schema::dropIfExists('offline_content');
        
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->dropColumn(['time_taken_seconds', 'started_at', 'submitted_at']);
        });
        
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->dropColumn(['average_score', 'completion_rate', 'total_attempts', 'average_time_seconds']);
        });
        
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn(['answer_media', 'answer_media_type']);
        });
        
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn([
                'question_media', 
                'question_media_type', 
                'difficulty',
                'time_limit_seconds',
                'tags'
            ]);
        });
    }
};
