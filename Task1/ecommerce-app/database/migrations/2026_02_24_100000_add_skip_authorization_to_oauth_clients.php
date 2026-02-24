<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add skip_authorization column to oauth_clients table.
     * This allows specific OAuth clients (e.g. Foodpanda SSO) to bypass
     * the authorization consent screen for seamless Single Sign-On.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('oauth_clients', 'skip_authorization')) {
            Schema::table('oauth_clients', function (Blueprint $table) {
                $table->boolean('skip_authorization')->default(false)->after('revoked');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('oauth_clients', 'skip_authorization')) {
            Schema::table('oauth_clients', function (Blueprint $table) {
                $table->dropColumn('skip_authorization');
            });
        }
    }
};
