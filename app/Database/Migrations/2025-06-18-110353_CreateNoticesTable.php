<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNoticesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'title'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'body'       => ['type' => 'TEXT'],
            'notice_date'=> ['type' => 'DATE'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('notices');
    }

    public function down()
    {
        $this->forge->dropTable('notices');
    }
}
