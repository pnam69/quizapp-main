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
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->integer('quiz_size')->nullable()->change();
            $table->foreignId('section_id')->nullable()->change();
            $table->foreignId('certification_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->integer('quiz_size')->nullable(false)->change();
            $table->foreignId('section_id')->nullable(false)->change();
            $table->foreignId('certification_id')->nullable(false)->change();
        });
    }
};
