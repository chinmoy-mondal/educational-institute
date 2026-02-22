<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRfidToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'rfid' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'assagin_sub', // place after assigned subjects
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'rfid');
    }
}