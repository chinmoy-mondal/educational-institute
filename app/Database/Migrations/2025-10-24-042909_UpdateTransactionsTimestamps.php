<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTransactionsTimestamps extends Migration
{
    public function up()
    {
        $fields = [
            'created_at' => [
                'name'    => 'created_at',
                'type'    => 'DATETIME',
                'null'    => false,
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'name'       => 'updated_at',
                'type'       => 'DATETIME',
                'null'       => false,
                'default'    => 'CURRENT_TIMESTAMP',
                'on update'  => 'CURRENT_TIMESTAMP',
            ],
        ];

        $this->forge->modifyColumn('transactions', $fields);
    }

    public function down()
    {
        $fields = [
            'created_at' => [
                'name'    => 'created_at',
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'updated_at' => [
                'name'    => 'updated_at',
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
        ];

        $this->forge->modifyColumn('transactions', $fields);
    }
}
