<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMpoDateBioPositionProfileToUsersTable extends Migration
{
    public function up()
    {
        $fields = [
            'position' => [
                'type'       => 'INT',
                'constraint' => 11,   // you can adjust depending on need
                'null'       => true,
            ],
            'social_profile' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,  // can store photo filename or type
                'null'       => true,
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['mpo_date', 'bio', 'position', 'profile']);
    }
}