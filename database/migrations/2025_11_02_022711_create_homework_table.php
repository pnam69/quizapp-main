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
        Schema::create('homework', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('instructions')->nullable();

            // Teacher who created the homework
            $table->foreignId('teacher_id')->constrained('users')->onDelete('cascade');

            // Organization
            $table->foreignId('certification_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('section_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('classroom_id')->nullable()->constrained()->onDelete('set null');

            // Assignment details
            $table->date('assigned_date')->default(now());
            $table->dateTime('due_date');
            $table->integer('max_points')->default(100);

            // Attachments
            $table->json('attachments')->nullable(); // File paths for assignment materials

            // Settings
            $table->boolean('allow_late_submission')->default(false);
            $table->boolean('is_published')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homework');
    }
};
