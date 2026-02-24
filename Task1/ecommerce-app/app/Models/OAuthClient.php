<?php

namespace App\Models;

use Laravel\Passport\Client as PassportClient;

/**
 * Custom OAuth2 Client model that respects the skip_authorization DB column.
 * When skip_authorization = 1 (e.g. Foodpanda SSO client), the Passport
 * authorization consent screen is bypassed for a seamless SSO experience.
 */
class OAuthClient extends PassportClient
{
    /**
     * Determine if the client should skip the authorization prompt.
     * Returns true if the client's skip_authorization column is set to 1.
     */
    public function skipsAuthorization(): bool
    {
        return (bool) $this->skip_authorization;
    }
}
