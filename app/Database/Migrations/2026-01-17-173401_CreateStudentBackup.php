<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentBackup extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'student_id'  => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'roll'        => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'class'       => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'section'     => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
            'assign_sub'  => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'year'        => [
                'type'       => 'YEAR',
            ],
            'created_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at'  => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true); // primary key
        $this->forge->createTable('student_backup', true);
    }

    public function down()
    {
        $this->forge->dropTable('student_backup', true);
    }
}