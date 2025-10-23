<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->foreignId('class_course_id')->nullable()->constrained('class_courses')->nullOnDelete()->after('quiz_id');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('class_course_id');
        });
    }
};