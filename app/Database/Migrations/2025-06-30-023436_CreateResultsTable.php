<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResultsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true],
            'teacher_id' => ['type' => 'INT', 'null' => false],
            'student_id' => ['type' => 'INT', 'null' => false],
            'subject_id' => ['type' => 'INT', 'null' => false],
            'exam'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'year'       => ['type' => 'INT', 'constraint' => 4, 'null' => false],
            'written'    => ['type' => 'INT', 'default' => 0],
            'mcq'        => ['type' => 'INT', 'default' => 0],
            'practical'  => ['type' => 'INT', 'default' => 0],
            'total'      => ['type' => 'INT', 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
//        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
  //      $this->forge->addForeignKey('subject_id', 'subjects', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('results');
    }

    public function down()
    {
        $this->forge->dropTable('results');
    }
}
