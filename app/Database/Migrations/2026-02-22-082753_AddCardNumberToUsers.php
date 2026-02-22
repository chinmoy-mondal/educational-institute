<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCardNumberToUsers extends Migration
{
    public function up()
    {
        // Add 'card_number' column to 'users'
        $fields = [
            'card_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'index_number', // optional: position in table
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        // Drop 'card_number' column
        $this->forge->dropColumn('users', 'card_number');
    }
}