<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    Schema::create('quiz_answers', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->foreignId('quiz_header_id')->constrained('quiz_headers')->onDelete('cascade');
    $table->foreignId('question_id')->constrained()->onDelete('cascade');
    $table->foreignId('answer_id')->constrained()->onDelete('cascade'); // <-- correct
    $table->boolean('is_correct')->default(false);
    $table->timestamps();
});

};
