<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUnitToFeesAmount extends Migration
{
    public function up()
    {
        $fields = [
            'unit' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'null'       => true,
                'after'      => 'title_id', // place it after title_id
                'comment'    => 'Unit (1–12)',
            ],
        ];

        $this->forge->addColumn('fees_amount', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('fees_amount', 'unit');
    }
}