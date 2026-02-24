<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class SSORedirectController extends Controller
{
    /**
     * Redirect authenticated user to OAuth authorize endpoint for Foodpanda SSO.
     */
    public function redirect(): RedirectResponse
    {
        $query = http_build_query([
            'client_id' => config('services.foodpanda.client_id'),
            'redirect_uri' => config('services.foodpanda.redirect_uri'),
            'response_type' => 'code',
            'scope' => '',
        ]);

        return redirect()->to(route('passport.authorizations.authorize').'?'.$query);
    }
}

