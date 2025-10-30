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
            $table->string('title')->nullable()->after('id');
            $table->uuid('link_token')->unique()->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('quiz_headers', function (Blueprint $table) {
            $table->dropColumn(['title', 'link_token']);
        });
    }
};
