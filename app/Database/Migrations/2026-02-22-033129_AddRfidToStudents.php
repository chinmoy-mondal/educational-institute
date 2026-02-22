<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRfidToStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('students', [
            'rfid' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'assign_sub', // position after assign_sub
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('students', 'rfid');
    }
}