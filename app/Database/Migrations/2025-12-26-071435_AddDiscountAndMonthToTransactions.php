<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDiscountAndMonthToTransactions extends Migration
{
    public function up()
    {
        $fields = [
            'discount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'default'    => '0.00',
                'after'      => 'amount', // place after 'amount'
            ],
            'month' => [
                'type'       => 'VARCHAR',
                'constraint' => 2,
                'null'       => true,
                'after'      => 'discount', // place after 'discount'
            ],
        ];

        $this->forge->addColumn('transactions', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', ['discount', 'month']);
    }
}