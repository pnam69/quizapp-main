<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('quiz_answers');
    }

    public function down(): void
    {
        // optional: recreate if you roll back
    }
};