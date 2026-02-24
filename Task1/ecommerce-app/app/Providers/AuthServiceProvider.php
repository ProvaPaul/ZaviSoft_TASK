<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\OAuthClient;
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

        // Use custom client model that supports skip_authorization for SSO
        Passport::useClientModel(OAuthClient::class);

        // Passport routes (/oauth/authorize, /oauth/token, etc.) are auto-registered
        // by Laravel Passport's PassportServiceProvider when $registersRoutes is true.

        // Access token expires in 1 hour
        Passport::tokensExpireIn(now()->addHours(1));

        // Refresh token expires in 7 days
        Passport::refreshTokensExpireIn(now()->addDays(7));

        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
