<?php
// app/Controllers/DevTools.php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Migrations;

class DevTools extends BaseController
{
    public function migrate($key = null)
    {
        // Add your own secure key here
        $secureKey = 'purnota@s';

        if ($key !== $secureKey) {
            return 'Unauthorized access';
        }

        try {
            $migrate = \Config\Services::migrations();
            $migrate->latest();

            return 'Migration completed successfully.';
        } catch (\Throwable $e) {
            return 'Migration failed: ' . $e->getMessage();
        }
    }
}
