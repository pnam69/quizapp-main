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
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->foreignId('section_id')->nullable()->change();
            $table->foreignId('certification_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->foreignId('section_id')->nullable(false)->change();
            $table->foreignId('certification_id')->nullable(false)->change();
        });
    }
};
