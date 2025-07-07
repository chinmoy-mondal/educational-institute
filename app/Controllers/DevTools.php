<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Services;

class DevTools extends Controller
{
    private string $secret;

    public function __construct()
    {
        // keep the key in .env →  DEVTOOLS_SECRET=purnota
        $this->secret = env('DEVTOOLS_SECRET', 'missing');
    }

    /* … existing migrate() & seed() … */

    // ───────────────────────────────────────────────
    // GET /dev-tools/migrate-status/{key}
    public function migrateStatus(string $key = null)
    {
        if ($key !== $this->secret) {
            return $this->response->setStatusCode(403)->setBody('Unauthorized');
        }

        $migrator = Services::migrations();

        // ① All migration files found in every namespace
        $files    = $migrator->findMigrations();      // [version => fullPath]

        // ② History rows already in the `migrations` table
        $history  = [];
        foreach ($migrator->getHistory() as $row) {   // CI4 ≥ 4.2
            $history[$row->version] = $row;           // quick lookup
        }

        // ③ Build a simple HTML table
        ob_start(); ?>
        <table border="1" cellpadding="6" cellspacing="0" style="font-family: monospace">
            <thead>
                <tr>
                    <th>Version</th>
                    <th>Class</th>
                    <th>Batch</th>
                    <th>Status</th>
                    <th>Ran&nbsp;At</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($files as $version => $path): 
                $class  = basename($path, '.php');
                $row    = $history[$version] ?? null; ?>
                <tr>
                    <td><?= esc($version) ?></td>
                    <td><?= esc($class)   ?></td>
                    <td><?= $row ? $row->batch ?? '-' : '-' ?></td>
                    <td><?= $row ? '✅ Yes' : '❌ No' ?></td>
                    <td><?= $row ? date('Y-m-d H:i:s', $row->time) : '-' ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php
        return ob_get_clean();
    }
}
