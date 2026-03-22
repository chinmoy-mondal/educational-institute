<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToLeavesTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('leaves', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'after'      => 'id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('leaves', 'user_id');
    }
}