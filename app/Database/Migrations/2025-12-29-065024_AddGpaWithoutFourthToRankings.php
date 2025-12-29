<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGpaWithoutFourthToRankings extends Migration
{
    public function up()
    {
        $this->forge->addColumn('rankings', [
            'gpa_without_forth' => [
                'type'       => 'DECIMAL',
                'constraint' => '4,2',
                'default'    => 0.00,
                'after'      => 'gpa', // optional: place after gpa
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rankings', 'gpa_without_forth');
    }
}