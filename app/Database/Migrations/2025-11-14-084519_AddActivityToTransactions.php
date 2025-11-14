<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddActivityToTransactions extends Migration
{
    public function up()
    {
        // Add new column 'activity' after 'status'
        $fields = [
            'activity' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 0,       // default value 0
                'after'      => 'status' // add after status
            ]
        ];
        $this->forge->addColumn('transactions', $fields);
    }

    public function down()
    {
        // Drop the 'activity' column if rollback
        $this->forge->dropColumn('transactions', 'activity');
    }
}
