<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateResultsTableWithRoll extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'teacher_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'student_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            // ✅ roll added here
            'roll' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],

            'subject_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            'exam' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],

            'year' => [
                'type'       => 'INT',
                'constraint' => 4,
            ],

            'class' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'null'       => true,
            ],

            'written' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            'mcq' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            'practical' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            'total' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            'publish' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('results', true);
    }

    public function down()
    {
        $this->forge->dropTable('results', true);
    }
}
