<?php
// filepath: database/migrations/2025_10_22_164213_add_class_course_id_to_quiz_headers_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            // add classroom_id (nullable) and FK to existing classrooms table
            $table->unsignedBigInteger('classroom_id')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->dropConstrainedForeignId('classroom_id');
        });
    }
};