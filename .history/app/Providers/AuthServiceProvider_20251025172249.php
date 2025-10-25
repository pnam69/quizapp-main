<?php
use Illuminate\Support\Facades\Gate;
namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];
    public function boot()
{
    $this->registerPolicies();

    // Give super_admin full access to everything in Filament
    Gate::before(function ($user, $ability) {
        return $user->hasRole('super_admin') ? true : null;
    });
}

    /**
     * Register any authentication / authorization services.
     */
}
