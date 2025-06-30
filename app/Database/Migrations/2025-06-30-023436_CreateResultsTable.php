<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResultsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'student_id' => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'subject_id' => ['type' => 'INT', 'unsigned' => true, 'null' => false],
            'exam'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'year'       => ['type' => 'INT', 'constraint' => 4, 'null' => false],
            'total'      => ['type' => 'INT', 'null' => false, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true); // primary key
        $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('subject_id', 'subjects', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('results');
    }

    public function down()
    {
        $this->forge->dropTable('results');
    }
}
