<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRfidLogs extends Migration
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
            'card_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'scan_time' => [
                'type' => 'DATETIME',
            ],
            'created_at DATETIME default CURRENT_TIMESTAMP',
            'updated_at DATETIME default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('rfid_logs');
    }

    public function down()
    {
        $this->forge->dropTable('rfid_logs');
    }
}
