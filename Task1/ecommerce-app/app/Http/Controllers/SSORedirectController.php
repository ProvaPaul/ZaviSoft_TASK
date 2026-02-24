<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;

class SSORedirectController extends Controller
{
    /**
     * Redirect authenticated user to OAuth authorize endpoint for Foodpanda SSO.
     * Builds Authorization Code Grant request and redirects to Passport's /oauth/authorize.
     */
    public function redirect(): RedirectResponse
    {
        $clientId = config('services.foodpanda.client_id');
        $redirectUri = config('services.foodpanda.redirect_uri');

        if (empty($clientId) || empty($redirectUri)) {
            Log::warning('SSO redirect failed: FOODPANDA_CLIENT_ID or FOODPANDA_REDIRECT_URI not configured.');
            return redirect()->route('dashboard')->with('error', 'SSO is not configured. Please set FOODPANDA_CLIENT_ID and FOODPANDA_REDIRECT_URI in .env');
        }

        $query = http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => '',
        ]);

        return redirect()->to(url('/oauth/authorize').'?'.$query);
    }
}

