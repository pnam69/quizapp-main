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
        Schema::create('homework_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homework_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            
            // Submission details
            $table->text('submission_text')->nullable();
            $table->json('submitted_files')->nullable(); // File paths for student submissions
            $table->dateTime('submitted_at')->nullable();
            
            // Grading
            $table->integer('score')->nullable();
            $table->text('teacher_feedback')->nullable();
            $table->foreignId('graded_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('graded_at')->nullable();
            
            // Status
            $table->enum('status', ['not_submitted', 'submitted', 'graded', 'late'])->default('not_submitted');
            
            $table->timestamps();
            
            // Ensure one submission per student per homework
            $table->unique(['homework_id', 'student_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework_submissions');
    }
};
