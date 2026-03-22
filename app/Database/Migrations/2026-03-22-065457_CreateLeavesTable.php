<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLeavesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'leave_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'from_datetime' => [
                'type' => 'DATETIME',
            ],
            'to_datetime' => [
                'type' => 'DATETIME',
            ],
            'reason' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'default'    => 'Pending',
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
        $this->forge->createTable('leaves');
    }

    public function down()
    {
        $this->forge->dropTable('leaves');
    }
}