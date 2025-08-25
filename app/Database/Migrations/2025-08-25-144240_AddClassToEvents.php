<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassToEvents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('events', [
            'class' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'null'       => true,
                'after'      => 'color', // put it after 'color' column
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('events', 'class');
    }
}