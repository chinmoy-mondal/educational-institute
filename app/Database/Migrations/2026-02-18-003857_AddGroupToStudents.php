<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGroupToStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('students', [
            'group' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'class'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('students', 'group');
    }
}