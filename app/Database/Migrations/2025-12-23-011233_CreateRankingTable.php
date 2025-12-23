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

            // current year roll
            'new_roll' => [
                'type'       => 'INT',
                'constraint' => 5,
            ],

            // student name snapshot (for faster report)
            'student_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],

            // previous year roll
            'past_roll' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
            ],

            // total marks of the year
            'total' => [
                'type'    => 'INT',
                'default' => 0,
            ],

            // percentage (e.g. 82.50)
            'percentage' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0.00,
            ],

            // academic year
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
        $this->forge->createTable('rankings', true);
    }

    public function down()
    {
        $this->forge->dropTable('rankings', true);
    }
}