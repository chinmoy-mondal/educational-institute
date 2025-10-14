<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassToEvents extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();

        // Drop first if exists
        $db = \Config\Database::connect();
        $fields = $db->getFieldNames('events');

        if (!in_array('category', $fields)) {
            $forge->addColumn('events', [
                'category' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ]
            ]);
        }

        if (!in_array('subcategory', $fields)) {
            $forge->addColumn('events', [
                'subcategory' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ]
            ]);
        }

        if (!in_array('class', $fields)) {
            $forge->addColumn('events', [
                'class' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                ]
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('events', ['category', 'subcategory', 'class']);
    }
}
