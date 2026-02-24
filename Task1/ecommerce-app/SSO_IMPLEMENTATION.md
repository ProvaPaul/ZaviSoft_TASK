# SSO Implementation Guide - Ecommerce App (OAuth2 Authorization Server)

This document describes the complete Single Sign-On (SSO) implementation where the **ecommerce-app** acts as an OAuth2 Authorization Server using Laravel Passport. Users logged into the Ecommerce system can seamlessly access the **foodpanda-app** without re-entering credentials.

---

## Quick Start — Login & See the Project

**Demo credentials** (after running `php artisan db:seed`):

- **Email:** `admin@ecommerce.test`
- **Password:** `password`

**Or register a new account** at `/register`.

1. Visit `http://localhost:8000` (or your server URL)
2. Click **Log in** or **Create Account**
3. Use demo credentials OR register
4. You'll land on the **Dashboard** with the "Go to Foodpanda" button

---

## PART 1 — Laravel Passport Installation & Configuration

### Artisan Commands Executed

```bash
# 1. Install Laravel Passport
composer require laravel/passport --ignore-platform-reqs

# 2. Publish Passport migrations
php artisan vendor:publish --tag=passport-migrations

# 3. Run migrations (creates oauth_* tables)
php artisan migrate

# 4. Install Passport (generates keys, creates personal/password grant clients)
php artisan passport:install

# 5. (Optional) Publish Passport config
php artisan vendor:publish --tag=passport-config
```

### Configuration Summary

- **User Model**: Uses `Laravel\Passport\HasApiTokens` trait (replaced Sanctum)
- **API Guard**: `config/auth.php` — `api` guard uses `passport` driver
- **Token Expiration**: `AuthServiceProvider` — Access: 1 hour, Refresh: 7 days
- **Passport Routes**: Auto-registered at `/oauth/*` (authorize, token, etc.)

---

## PART 2 — Protected API Route

**Route**: `GET /api/user`  
**Middleware**: `auth:api`  
**Returns**: Authenticated user JSON

Defined in `routes/api.php` and handled by `App\Http\Controllers\Api\UserController@show`.

---

## PART 3 — Create OAuth Client for Foodpanda

Run the following command to create an **Authorization Code** client:

```bash
php artisan passport:client
```

When prompted:

1. **Which user ID should the client be assigned to?** — Enter `1` (or your admin user ID)
2. **What should we name the client?** — Enter `Foodpanda SSO`
3. **Where should we redirect the request after authorization?** — Enter `http://localhost:8001/callback`
4. **Create a confidential client?** — Select `no` for a public client, or `yes` for confidential (recommended for backend)

The command will output:

- **Client ID** — Store this in `.env` as `FOODPANDA_CLIENT_ID`
- **Client secret** (if confidential) — Store as `FOODPANDA_CLIENT_SECRET` (optional for this flow)

**Where Client ID is stored**: In `.env` and accessed via `config('services.foodpanda.client_id')`.

---

## PART 4 & 5 — Environment Configuration

Add to `.env` and `.env.example`:

```env
FOODPANDA_CLIENT_ID=
FOODPANDA_REDIRECT_URI=http://localhost:8001/callback
```

After running `php artisan passport:client`, paste the generated Client ID into `FOODPANDA_CLIENT_ID`.

---

## PART 6 — SSORedirectController

**Location**: `app/Http/Controllers/SSORedirectController.php`

- Ensures user is authenticated (via `auth` middleware)
- Builds OAuth authorize query: `client_id`, `redirect_uri`, `response_type=code`, `scope=`
- Redirects to `/oauth/authorize?query_string`

---

## PART 7 — Web Routes

**File**: `routes/web.php`

Includes default Breeze auth routes and:

```php
Route::get('/redirect-to-foodpanda', [SSORedirectController::class, 'redirect'])
    ->middleware('auth')
    ->name('redirect.foodpanda');
```

---

## PART 8 — Frontend Button

**Location**: `resources/views/dashboard.blade.php`

A "Go to Foodpanda" button links to `route('redirect.foodpanda')`. The dashboard is shown to authenticated users after login (Breeze default).

---

## PART 9 — OAuth Flow (Step-by-Step)

1. **User logs in to Ecommerce** — Uses Breeze login at `/login`. Session is created.
2. **User clicks "Go to Foodpanda"** — Hits `/redirect-to-foodpanda` (protected by `auth`).
3. **Redirect to `/oauth/authorize`** — SSORedirectController builds the URL with `client_id`, `redirect_uri`, `response_type=code`, `scope=` and redirects.
4. **Passport shows authorization screen** — User approves access for the Foodpanda client.
5. **Passport generates authorization code** — Short-lived code is created.
6. **Redirect to Foodpanda callback** — User is sent to `http://localhost:8001/callback?code=XXX&state=...`
7. **Foodpanda exchanges code for token** — Foodpanda backend sends `POST` to ecommerce `https://ecommerce-app/oauth/token` with:
   - `grant_type=authorization_code`
   - `client_id`
   - `client_secret` (if confidential)
   - `redirect_uri`
   - `code`
8. **Ecommerce returns access_token & refresh_token** — Foodpanda uses the access token to call ecommerce APIs (e.g. `/api/user`) and logs the user in locally.

---

## Folder Structure (Relevant Files)

```
ecommerce-app/
├── app/
│   ├── Http/Controllers/
│   │   ├── Api/
│   │   │   └── UserController.php
│   │   └── SSORedirectController.php
│   ├── Models/
│   │   └── User.php
│   └── Providers/
│       └── AuthServiceProvider.php
├── config/
│   ├── auth.php
│   ├── passport.php
│   └── services.php
├── database/migrations/
│   └── *_create_oauth_*_table.php
├── resources/views/
│   └── dashboard.blade.php
├── routes/
│   ├── api.php
│   └── web.php
└── ENV_FOODPANDA_ADDITIONS.txt
```

---

## Running the Ecommerce App

```bash
php artisan serve
```

Default: `http://localhost:8000`

---

## Foodpanda App Requirements

The **foodpanda-app** (separate Laravel project) must:

1. Implement a callback route at `/callback` that receives `?code=...`
2. Exchange the code for tokens via `POST /oauth/token` on the ecommerce-app
3. Store the access token and use it for API calls
4. Create a local session/user based on the authenticated user from ecommerce

Both apps remain independent Laravel applications; ecommerce is the Authorization Server, foodpanda is the OAuth Client.

