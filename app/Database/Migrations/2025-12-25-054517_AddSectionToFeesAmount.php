<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSectionToFeesAmount extends Migration
{
    public function up()
    {
        $fields = [
            'section' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
                'after'      => 'class',
                'collation'  => 'utf8mb4_unicode_ci',
            ],
        ];

        $this->forge->addColumn('fees_amount', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('fees_amount', 'section');
    }
}