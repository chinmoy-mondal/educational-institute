<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMpoDateAndBioToUsersTable extends Migration
{
    public function up()
    {
        $fields = [
            'mpo_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'bio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['mpo_date', 'bio']);
    }
}