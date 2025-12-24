<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAddressToStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('students', [
            'address' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'esif', // optional: place after esif
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('students', 'address');
    }
}