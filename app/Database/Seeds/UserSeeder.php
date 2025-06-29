<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'  => 'John Doe',
                'email' => 'john@example.com',
            ],
            [
                'name'  => 'Jane Doe',
                'email' => 'jane@example.com',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
