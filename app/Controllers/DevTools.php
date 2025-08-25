<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class DevTools extends BaseController
{
    private $secret = 'purnota'; // Your secret key for security

    /**
     * Run latest migrations
     * URL: /devtools/migrate/purnota
     */
    public function migrate($key = null)
    {
        if ($key !== $this->secret) {
            return $this->response->setStatusCode(403)->setBody('Unauthorized');
        }

        $migrations = Services::migrations();

        try {
            $migrations->latest();
            return "✅ Migration completed successfully.";
        } catch (\Throwable $e) {
            return "❌ Migration failed: " . $e->getMessage();
        }
    }

    /**
     * Rollback last batch
     * URL: /devtools/rollback/purnota
     */
    public function rollback($key = null)
    {
        if ($key !== $this->secret) {
            return $this->response->setStatusCode(403)->setBody('Unauthorized');
        }

        $migrations = Services::migrations();

        try {
            $batch = $migrations->regress();
            if ($batch === false) {
                return "⚠️ No migrations to rollback.";
            }
            return "✅ Rollback completed successfully.";
        } catch (\Throwable $e) {
            return "❌ Rollback failed: " . $e->getMessage();
        }
    }

    /**
     * Reset all migrations
     * URL: /devtools/reset/purnota
     */
    public function reset($key = null)
    {
        if ($key !== $this->secret) {
            return $this->response->setStatusCode(403)->setBody('Unauthorized');
        }

        $migrations = Services::migrations();

        try {
            // Keep rolling back until no migrations are left
            while (true) {
                $batch = $migrations->regress();
                if ($batch === false) break;
            }

            return "✅ All migrations have been rolled back (reset).";
        } catch (\Throwable $e) {
            return "❌ Reset failed: " . $e->getMessage();
        }
    }

    /**
     * Check migration status
     * URL: /devtools/status/purnota
     */
    public function status($key = null)
    {
        if ($key !== $this->secret) {
            return $this->response->setStatusCode(403)->setBody('Unauthorized');
        }

        try {
            $db = \Config\Database::connect();
            $builder = $db->table('ci_migrations');

            $migrations = $builder->get()->getResultArray();

            if (empty($migrations)) {
                return "⚠️ No migrations applied yet.";
            }

            $output = "<pre>";
            foreach ($migrations as $migration) {
                $output .= sprintf(
                    "%s | %s | %s\n",
                    $migration['version'],
                    $migration['class'],
                    $migration['group']
                );
            }
            $output .= "</pre>";

            return $output;
        } catch (\Throwable $e) {
            return "❌ Status check failed: " . $e->getMessage();
        }
    }
}