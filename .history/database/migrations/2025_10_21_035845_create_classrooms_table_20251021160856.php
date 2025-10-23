<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('class_courses', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('course_year')->nullable();
    $table->foreignId('main_teacher_id')->nullable()->constrained('users');
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
