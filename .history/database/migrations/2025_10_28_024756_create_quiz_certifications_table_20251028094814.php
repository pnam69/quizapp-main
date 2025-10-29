<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // create_quiz_certification_table
Schema::create('quiz_certification', function (Blueprint $table) {
    $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();
    $table->foreignId('certification_id')->constrained()->cascadeOnDelete();
    $table->primary(['quiz_id', 'certification_id']);
});

    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_certification');
    }
};
