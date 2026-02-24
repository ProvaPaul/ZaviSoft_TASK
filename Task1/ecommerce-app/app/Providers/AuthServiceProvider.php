<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::hashClientSecrets();

        // Access token expires in 1 hour
        Passport::tokensExpireIn(now()->addHours(1));

        // Refresh token expires in 7 days
        Passport::refreshTokensExpireIn(now()->addDays(7));

        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
