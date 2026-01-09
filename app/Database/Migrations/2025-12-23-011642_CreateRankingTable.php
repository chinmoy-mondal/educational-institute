<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRankingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'student_id' => [
                'type'     => 'INT',
                'unsigned' => true,
            ],

            // Class (6–10 etc.)
            'class' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
            ],

            // Current year roll
            'new_roll' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],

            // Student name snapshot
            'student_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            // Previous year roll
            'past_roll' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],

            // Total marks
            'total' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            // Percentage (e.g. 85.75)
            'percentage' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],

            // GPA
            'gpa' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,2',
                'default'    => 0.00,
            ],

            'gpa_without_forth' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,2',
                'default'    => 0.00,
            ],
            
            // Letter Grade
            'grade_letter' => [
                'type'       => 'VARCHAR',
                'constraint' => 2,
                'null'       => true,
            ],

            'fail' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'default'    => 0,
            ],

            // Academic year
            'year' => [
                'type'       => 'INT',
                'constraint' => 4,
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

        // Optional but recommended for faster ranking queries
        $this->forge->addKey(['class', 'year']);

        $this->forge->createTable('rankings', true);
    }

    public function down()
    {
        $this->forge->dropTable('rankings', true);
    }
}