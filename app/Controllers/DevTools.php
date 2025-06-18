<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use Config\Services;

class DevTools extends BaseController
{
    public function migrate()
    {
        $migrations = Services::migrations();
        try {
            $migrations->latest();
            return 'Migration completed.';
        } catch (\Throwable $e) {
            return 'Migration failed: ' . $e->getMessage();
        }
    }

    public function seed()
    {
        $seeder = \Config\Database::seeder();
        try {
            $seeder->call('NoticeSeeder');
            return 'Seeding completed.';
        } catch (\Throwable $e) {
            return 'Seeding failed: ' . $e->getMessage();
        }
    }
}
