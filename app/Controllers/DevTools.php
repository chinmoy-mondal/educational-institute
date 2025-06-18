<?php 
namespace App\Controllers;

use CodeIgniter\Controller;

class DevTools extends BaseController
{
    public function migrate()
    {
        \CodeIgniter\Commands::migrate(0); // or use Services::migrations()->latest();
        return 'Migration completed.';
    }

    public function seed()
    {
        $seeder = \Config\Database::seeder();
        $seeder->call('NoticeSeeder');
        return 'Seeding completed.';
    }
}
