<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPermissionToStudents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('students', [
            'permission' => [
                'type'       => 'TINYINT',
                'constraint' => 1,       // behaves like boolean
                'null'       => false,
                'default'    => 0,       // 0 = not allowed, 1 = allowed
                'after'      => 'assign_sub', // ✅ place after assign_sub
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('students', 'permission');
    }
}