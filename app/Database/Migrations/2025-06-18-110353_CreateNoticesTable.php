<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNoticesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title'        => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'body'         => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'notice_date'  => [
                'type' => 'DATE',
                'null' => false,
            ],
            'document_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'status'       => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1, // 1 = Active, 0 = Inactive
                'null'       => false,
            ],
            'created_at'   => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at'   => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('notices', true);
    }

    public function down()
    {
        $this->forge->dropTable('notices', true);
    }
}