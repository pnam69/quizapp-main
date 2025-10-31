<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log every SQL query
        DB::listen(function ($query) {
            Log::info('SQL', [
                'sql' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
            ]);
        });

        // Log User model changes
        User::saving(function ($user) {
            Log::info('User saving (BEFORE save)', $user->getAttributes());
        });

        User::saved(function ($user) {
            Log::info('User saved (AFTER save)', $user->getAttributes());
        });
    }
}
