<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUpdatedAtToCostTypes extends Migration
{
    public function up()
    {
        $fields = [
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ]
        ];

        $this->forge->addColumn('cost_types', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('cost_types', 'updated_at');
    }
}