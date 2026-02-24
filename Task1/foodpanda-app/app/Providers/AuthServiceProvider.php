<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
<<<<<<< HEAD
=======
use Laravel\Passport\Passport;
>>>>>>> 10c2979b2be322958648dcb15add19f1013cb4ff

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
<<<<<<< HEAD
        //
=======
        $this->registerPolicies();

        Passport::hashClientSecrets();

        // Access token expires in 1 hour
        Passport::tokensExpireIn(now()->addHours(1));

        // Refresh token expires in 7 days
        Passport::refreshTokensExpireIn(now()->addDays(7));

        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
>>>>>>> 10c2979b2be322958648dcb15add19f1013cb4ff
    }
}
