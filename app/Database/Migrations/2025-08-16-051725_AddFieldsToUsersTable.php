<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFieldsToUsersTable extends Migration
{
    public function up()
    {
        $fields = [
            'index_number' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true,
            ],
            'dob' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'joining_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['index_number', 'dob', 'joining_date', 'religion']);
    }
}