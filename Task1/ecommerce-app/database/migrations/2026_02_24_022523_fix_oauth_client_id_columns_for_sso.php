<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Fixes "Data truncated for column 'client_id'" when client_id from OAuth request
     * is a long string. Changes BIGINT to VARCHAR(255) to support any client ID format.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement('ALTER TABLE oauth_auth_codes MODIFY COLUMN client_id VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE oauth_access_tokens MODIFY COLUMN client_id VARCHAR(255) NOT NULL');
            DB::statement('ALTER TABLE oauth_personal_access_clients MODIFY COLUMN client_id VARCHAR(255) NOT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE oauth_auth_codes ALTER COLUMN client_id TYPE VARCHAR(255)');
            DB::statement('ALTER TABLE oauth_access_tokens ALTER COLUMN client_id TYPE VARCHAR(255)');
            DB::statement('ALTER TABLE oauth_personal_access_clients ALTER COLUMN client_id TYPE VARCHAR(255)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement('ALTER TABLE oauth_auth_codes MODIFY COLUMN client_id BIGINT UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE oauth_access_tokens MODIFY COLUMN client_id BIGINT UNSIGNED NOT NULL');
            DB::statement('ALTER TABLE oauth_personal_access_clients MODIFY COLUMN client_id BIGINT UNSIGNED NOT NULL');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE oauth_auth_codes ALTER COLUMN client_id TYPE BIGINT USING client_id::BIGINT');
            DB::statement('ALTER TABLE oauth_access_tokens ALTER COLUMN client_id TYPE BIGINT USING client_id::BIGINT');
            DB::statement('ALTER TABLE oauth_personal_access_clients ALTER COLUMN client_id TYPE BIGINT USING client_id::BIGINT');
        }
    }
};
