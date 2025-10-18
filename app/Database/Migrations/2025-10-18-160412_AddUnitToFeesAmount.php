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
                'comment'    => 'Month unit (1–12)',
                'after'      => 'fee_id', // position after fee_id
            ],
        ];

        $this->forge->addColumn('fees_amount', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('fees_amount', 'unit');
    }
}