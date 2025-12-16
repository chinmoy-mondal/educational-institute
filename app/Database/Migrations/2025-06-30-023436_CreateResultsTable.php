<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResultsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'teacher_id' => ['type' => 'INT', 'null' => false, 'unsigned' => true],
            'student_id' => ['type' => 'INT', 'null' => false, 'unsigned' => true],
            'subject_id' => ['type' => 'INT', 'null' => false, 'unsigned' => true],
            'exam'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'year'       => ['type' => 'INT', 'constraint' => 4, 'null' => false],
            'class'      => ['type' => 'TINYINT', 'constraint' => 2, 'null' => true],
            'written'    => ['type' => 'INT', 'default' => 0],
            'mcq'        => ['type' => 'INT', 'default' => 0],
            'practical'  => ['type' => 'INT', 'default' => 0],
            'total'      => ['type' => 'INT', 'default' => 0],
            'publish'    => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);

        // Optional: add foreign keys if needed
        // $this->forge->addForeignKey('student_id', 'students', 'id', 'CASCADE', 'CASCADE');
        // $this->forge->addForeignKey('subject_id', 'subjects', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('results', true);
    }

    public function down()
    {
        $this->forge->dropTable('results', true);
    }
}
