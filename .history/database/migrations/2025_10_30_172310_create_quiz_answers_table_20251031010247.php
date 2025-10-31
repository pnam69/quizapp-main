<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->dropForeign(['option_id']);
            $table->dropColumn('option_id');

            $table->foreignId('answer_id')->constrained('answers')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_answers', function (Blueprint $table) {
            $table->dropForeign(['answer_id']);
            $table->dropColumn('answer_id');

            $table->foreignId('option_id')->constrained('options')->onDelete('cascade');
        });
    }
};
