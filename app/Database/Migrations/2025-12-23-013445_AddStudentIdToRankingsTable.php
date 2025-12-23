<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStudentIdToRankingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('rankings', [
            'student_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'after'    => 'id', // keeps structure clean
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rankings', 'student_id');
    }
}