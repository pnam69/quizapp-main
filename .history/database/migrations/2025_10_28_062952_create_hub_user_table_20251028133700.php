<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hub_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hub_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Optional: move existing `user_id` from hubs table
        \DB::statement('INSERT INTO hub_user (hub_id, user_id, created_at, updated_at)
                        SELECT id, user_id, NOW(), NOW() FROM hubs WHERE user_id IS NOT NULL');

        Schema::table('hubs', function (Blueprint $table) {
            $table->dropColumn('user_id'); // remove old single-user column
        });
    }

    public function down(): void
    {
        Schema::table('hubs', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
        });
        Schema::dropIfExists('hub_user');
    }
};
