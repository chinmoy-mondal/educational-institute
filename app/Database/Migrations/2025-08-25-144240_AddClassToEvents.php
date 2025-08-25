<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassToEvents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('events', [
            'category' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'subcategory' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'class' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('events', ['category', 'subcategory', 'class']);
    }
}