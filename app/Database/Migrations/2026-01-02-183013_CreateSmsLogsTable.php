<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSmsLogsTable extends Migration
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

            'student_name' => [               // NEW FIELD
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],

            'phone_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],

            'message' => [
                'type' => 'TEXT',
                'null' => false,
            ],

            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0, // 0 = failed, 1 = sent
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('sms_logs', true);
    }

    public function down()
    {
        $this->forge->dropTable('sms_logs', true);
    }
}