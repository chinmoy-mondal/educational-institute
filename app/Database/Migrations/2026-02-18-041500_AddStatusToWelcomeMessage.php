<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToWelcomeMessage extends Migration
{
    public function up()
    {
        $this->forge->addColumn('welcome_message', [
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'after'      => 'message',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('welcome_message', 'status');
    }
}