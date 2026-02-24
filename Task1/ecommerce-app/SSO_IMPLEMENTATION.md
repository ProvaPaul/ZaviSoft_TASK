# SSO Implementation Guide — Ecommerce App (OAuth2 Authorization Server)

This document describes the complete Single Sign-On (SSO) implementation where **ecommerce-app** acts as an OAuth2 Authorization Server using Laravel Passport. Users logged into the Ecommerce system can seamlessly access **foodpanda-app** without re-entering credentials.

---

## Objective

- **ecommerce-app** handles normal Laravel authentication (login/register)
- Acts as OAuth2 Authorization Server
- Issues authorization codes
- Issues access tokens
- Redirects authenticated user to foodpanda-app

---

## Folder Structure (Relevant Files)

```
ecommerce-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/
│   │   │   └── UserController.php      # GET /api/user
│   │   └── SSORedirectController.php   # Redirect to OAuth authorize
│   ├── Models/
│   │   └── User.php                    # HasApiTokens trait
│   └── Providers/
│       └── AuthServiceProvider.php     # Passport config
├── config/
│   ├── auth.php                        # api guard uses passport
│   ├── passport.php
│   └── services.php                    # foodpanda client config
├── database/migrations/
│   └── 2016_06_01_*_create_oauth_*.php
├── resources/views/
│   └── dashboard.blade.php             # "Go to Foodpanda" button
├── routes/
│   ├── api.php                         # Protected GET /api/user
│   └── web.php                         # /redirect-to-foodpanda
├── ENV_EXAMPLE_ADDITIONS.txt           # Add to .env / .env.example
└── SSO_IMPLEMENTATION.md               # This file
```

---

## STEP 1 — Install & Configure Passport

### Artisan Commands

```bash
composer require laravel/passport
php artisan vendor:publish --tag=passport-migrations
php artisan migrate
php artisan passport:install
```

### config/auth.php

API guard uses Passport driver:

```php
'api' => [
    'driver' => 'passport',
    'provider' => 'users',
],
```

### User Model

```php
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ...
}
```

### AuthServiceProvider

- Passport routes are **auto-registered** at `/oauth/*` (Passport 11+)
- Token expiration:
  - **Access token** → 1 hour
  - **Refresh token** → 7 days

---

## STEP 2 — Protected API Route

**File:** `routes/api.php`

```php
Route::middleware('auth:api')->get('/user', [UserController::class, 'show']);
```

- **URL:** `GET /api/user`
- **Middleware:** `auth:api` (Passport)
- **Returns:** Authenticated user JSON

---

## STEP 3 — Create OAuth Client

Run:

```bash
php artisan passport:client
```

When prompted:

1. **Which user ID should the client be assigned to?** — `1` (or admin user ID)
2. **What should we name the client?** — `Foodpanda SSO`
3. **Where should we redirect the request after authorization?** — `http://127.0.0.1:8001/callback`
4. **Create a confidential client?** — `yes` (recommended) or `no` for public

The command outputs:

- **Client ID** (numeric, e.g. `3`) → Store in `.env` as `FOODPANDA_CLIENT_ID`
- **Client secret** (long string) → Store as `FOODPANDA_CLIENT_SECRET` (used by foodpanda when exchanging code for token)

**Important:** Use the **numeric Client ID** (e.g. `3`), NOT the Client Secret. Do not confuse them.

**Usage:**  
- **Client ID** is used in ecommerce-app's SSORedirectController and in foodpanda-app's token exchange request.  
- **Client secret** is used only by foodpanda-app when calling `POST /oauth/token` to exchange the authorization code for tokens.

---

## STEP 4 — config/services.php

```php
'foodpanda' => [
    'client_id' => env('FOODPANDA_CLIENT_ID'),
    'redirect_uri' => env('FOODPANDA_REDIRECT_URI'),
],
```

---

## STEP 5 — .env Example

Add to `.env` and `.env.example`:

```env
FOODPANDA_CLIENT_ID=
FOODPANDA_REDIRECT_URI=http://127.0.0.1:8001/callback
```

After running `php artisan passport:client`, paste the generated Client ID into `FOODPANDA_CLIENT_ID`.

See `ENV_EXAMPLE_ADDITIONS.txt` for the same content.

---

## STEP 6 — SSORedirectController

**File:** `app/Http/Controllers/SSORedirectController.php`

- Ensures user is authenticated (via `auth` middleware)
- Builds OAuth authorize query: `client_id`, `redirect_uri`, `response_type=code`, `scope=`
- Redirects to `/oauth/authorize?query_string`

---

## STEP 7 — routes/web.php

```php
use App\Http\Controllers\SSORedirectController;

Route::middleware(['auth'])->group(function () {
    Route::get('/redirect-to-foodpanda', [SSORedirectController::class, 'redirect'])
        ->name('redirect.foodpanda');
});
```

Default Laravel/Breeze auth routes remain in `auth.php`.

---

## STEP 8 — Dashboard Button

**File:** `resources/views/dashboard.blade.php`

Add a link/button:

```html
<a href="{{ route('redirect.foodpanda') }}" class="...">
    Go to Foodpanda
</a>
```

The dashboard is shown to authenticated users after login.

---

## STEP 9 — OAuth Flow (Step-by-Step)

1. **User logs in to ecommerce-app** — Uses Breeze login at `/login`. Session is created.
2. **User clicks "Go to Foodpanda"** — Requests `/redirect-to-foodpanda` (protected by `auth`).
3. **Redirect to `/oauth/authorize`** — SSORedirectController builds the URL with `client_id`, `redirect_uri`, `response_type=code`, `scope=` and redirects.
4. **Passport authorization screen** — User sees and approves access for the Foodpanda client.
5. **Passport generates authorization code** — Short-lived code is created.
6. **Redirect to Foodpanda callback** — User is sent to:
   ```
   http://127.0.0.1:8001/callback?code=XXXX&state=...
   ```
7. **Foodpanda exchanges code for token** — Foodpanda backend sends `POST` to:
   ```
   http://127.0.0.1:8000/oauth/token
   ```
   With:
   - `grant_type=authorization_code`
   - `client_id`
   - `client_secret` (if confidential)
   - `redirect_uri`
   - `code`
8. **Ecommerce returns tokens** — Response includes `access_token`, `refresh_token`, and `expires_in`.
9. **Foodpanda uses access token** — Calls ecommerce APIs (e.g. `GET /api/user`) and logs the user in locally.

---

## Running the Ecommerce App

```bash
cd ecommerce-app
php artisan serve
```

Default: `http://127.0.0.1:8000`

---

## Foodpanda App Requirements

The **foodpanda-app** (separate Laravel project) must:

1. Implement a callback route at `/callback` that receives `?code=...`
2. Exchange the code for tokens via `POST http://127.0.0.1:8000/oauth/token`
3. Store the access token and use it for API calls
4. Create a local session/user based on the authenticated user from ecommerce

Both apps remain independent Laravel applications; ecommerce is the Authorization Server, foodpanda is the OAuth Client.

---

## Troubleshooting

### "Data truncated for column 'client_id'" error

This occurred when `FOODPANDA_CLIENT_ID` was set to a long string (e.g. the Client Secret). A migration has been added to support string client IDs. For correct behavior:

1. Use the **numeric Client ID** from `php artisan passport:client` (e.g. `3` for Foodpanda SSO).
2. In `.env`: `FOODPANDA_CLIENT_ID=3` (replace `3` with your actual client ID from the `oauth_clients` table).
