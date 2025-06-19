<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateElectricBillsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            'customer_name'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'meter_number'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'billing_month'  => ['type' => 'VARCHAR', 'constraint' => 20], // e.g. "June 2025"
            'units_used'     => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'rate_per_unit'  => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'total_amount'   => ['type' => 'DECIMAL', 'constraint' => '10,2'],
            'paid_status'    => ['type' => 'ENUM', 'constraint' => ['paid', 'unpaid'], 'default' => 'unpaid'],
            'due_date'       => ['type' => 'DATE', 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => true],
            'updated_at'     => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('electric_bills');
    }

    public function down()
    {
        $this->forge->dropTable('electric_bills');
    }
}
