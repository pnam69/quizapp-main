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
        Schema::create('my_quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('questions')->nullable();   // store questions/answers here
            $table->boolean('public')->default(true);
            $table->uuid('link_token')->unique();
            $table->timestamps();
        });


        /**
         * Reverse the migrations.
         */
    public function down(): void
    {
        Schema::dropIfExists('my_quizzes');
    }
};
