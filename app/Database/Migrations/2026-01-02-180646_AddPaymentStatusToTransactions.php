<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPaymentStatusToTransactions extends Migration
{
    public function up()
    {
        $fields = [
            'payment_status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0, // 0 = not paid, 1 = paid
                'comment'    => '0=Not Paid, 1=Paid',
                'after'      => 'description', // position after description
            ],
        ];

        $this->forge->addColumn('transactions', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('transactions', 'payment_status');
    }
}