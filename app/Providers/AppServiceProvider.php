<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Automatically provision database, run migrations and seeds if using a new database
        if (!$this->app->runningInConsole()) {
            $this->ensureDatabaseAndTablesExist();
        }
    }

    /**
     * Ensure database exists, tables are migrated and pre-seeded automatically.
     */
    protected function ensureDatabaseAndTablesExist(): void
    {
        try {
            $driver = config('database.default', 'mysql');
            $dbName = config("database.connections.{$driver}.database");
            $dbHost = config("database.connections.{$driver}.host", '127.0.0.1');
            $dbPort = config("database.connections.{$driver}.port", '3306');
            $dbUser = config("database.connections.{$driver}.username", 'root');
            $dbPass = config("database.connections.{$driver}.password", 'root');

            if ($driver === 'mysql' && $dbName) {
                try {
                    DB::connection()->getPdo();
                } catch (\Throwable $e) {
                    // If database does not exist (MySQL 1049: Unknown database), create it automatically
                    if (str_contains($e->getMessage(), 'Unknown database') || str_contains($e->getMessage(), '1049')) {
                        $pdo = new \PDO("mysql:host={$dbHost};port={$dbPort}", $dbUser, $dbPass);
                        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
                        DB::purge($driver);
                        DB::reconnect($driver);
                    } else {
                        return;
                    }
                }
            }

            // If key tables do not exist in the database, automatically migrate & seed
            if (!Schema::hasTable('users') || !Schema::hasTable('students') || !Schema::hasTable('roles')) {
                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('db:seed', ['--force' => true]);
            }
        } catch (\Throwable $e) {
            Log::warning('Auto database migration warning: ' . $e->getMessage());
        }
    }
}
