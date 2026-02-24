<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SSOCallbackController extends Controller
{
    /**
     * Handle the OAuth2 authorization code callback from ecommerce-app.
     *
     * Flow:
     *  1. Receive ?code=... from ecommerce's Passport /oauth/authorize
     *  2. Exchange code for access token via POST /oauth/token on ecommerce
     *  3. Use access token to fetch user info from ecommerce GET /api/user
     *  4. Find or create the user locally in foodpanda's DB
     *  5. Log the user into foodpanda's session
     *  6. Redirect to foodpanda dashboard
     */
    public function handle(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            Log::error('SSO Callback: no code received', $request->all());
            return redirect('/')->with('error', 'SSO login failed: no authorization code received.');
        }

        $ecommerceUrl   = config('services.ecommerce.url');
        $clientId       = config('services.ecommerce.client_id');
        $clientSecret   = config('services.ecommerce.client_secret');
        $redirectUri    = config('services.ecommerce.redirect_uri');

        // Step 1: Exchange authorization code for access token
        try {
            $tokenResponse = Http::asForm()->post("{$ecommerceUrl}/oauth/token", [
                'grant_type'    => 'authorization_code',
                'client_id'     => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri'  => $redirectUri,
                'code'          => $code,
            ]);
        } catch (\Exception $e) {
            Log::error('SSO Callback: token exchange failed', ['error' => $e->getMessage()]);
            return redirect('/')->with('error', 'SSO login failed: could not connect to ecommerce server.');
        }

        if (!$tokenResponse->successful()) {
            Log::error('SSO Callback: token exchange error', ['response' => $tokenResponse->body()]);
            return redirect('/')->with('error', 'SSO login failed: token exchange error.');
        }

        $accessToken = $tokenResponse->json('access_token');

        if (!$accessToken) {
            return redirect('/')->with('error', 'SSO login failed: no access token returned.');
        }

        // Step 2: Fetch user info from ecommerce using access token
        try {
            $userResponse = Http::withToken($accessToken)
                ->get("{$ecommerceUrl}/api/user");
        } catch (\Exception $e) {
            Log::error('SSO Callback: user fetch failed', ['error' => $e->getMessage()]);
            return redirect('/')->with('error', 'SSO login failed: could not fetch user info.');
        }

        if (!$userResponse->successful()) {
            Log::error('SSO Callback: user fetch error', ['response' => $userResponse->body()]);
            return redirect('/')->with('error', 'SSO login failed: could not get user data.');
        }

        $userData = $userResponse->json();

        // Step 3: Find or create local user (synced from ecommerce)
        $user = User::firstOrCreate(
            ['email' => $userData['email']],
            [
                'name'              => $userData['name'],
                'password'          => Hash::make(uniqid('sso_', true)), // random password – SSO only
                'email_verified_at' => now(),
            ]
        );

        // Keep name in sync if it changed on ecommerce side
        if ($user->name !== $userData['name']) {
            $user->update(['name' => $userData['name']]);
        }

        // Step 4: Log the user into foodpanda's session
        Auth::login($user, remember: true);

        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Welcome to Foodpanda! You are logged in via Ecommerce SSO.');
    }
}
