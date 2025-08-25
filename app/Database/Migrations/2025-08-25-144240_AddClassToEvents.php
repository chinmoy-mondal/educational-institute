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
        ]);
    }

    public function down()
    {
        // Drop both columns at once
        $this->forge->dropColumn('events', ['category', 'subcategory']);
    }
}