<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToTransactions extends Migration
{
    public function up()
    {
        $fields = [
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'after'      => 'description',
                'comment'    => '0 = inactive, 1 = active',
            ],
        ];

        $this->forge->addColumn('transactions', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', 'status');
    }
}
