<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class DevTools extends BaseController
{
    private $secret = 'purnota'; // ✅ Your custom secret key

    public function migrate($key = null)
    {
        if ($key !== $this->secret) {
            return $this->response->setStatusCode(403)->setBody('Unauthorized');
        }

        $migrations = Services::migrations();
        try {
            $migrations->latest();
            return 'Migration completed.';
        } catch (\Throwable $e) {
            return 'Migration failed: ' . $e->getMessage();
        }
    }

    public function seed($key = null)
    {
        if ($key !== $this->secret) {
            return $this->response->setStatusCode(403)->setBody('Unauthorized');
        }

        $seeder = \Config\Database::seeder();
        try {
            $seeder->call('NoticeSeeder');
	    $seeder->call('ImportSubjectsSeeder');
            return 'Seeding completed.';
        } catch (\Throwable $e) {
            return 'Seeding failed: ' . $e->getMessage();
        }
    }
}
