<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFailFieldToRankings extends Migration
{
    public function up()
    {
        $this->forge->addColumn('rankings', [
            'fail' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'default'    => 0,
                'after'      => 'grade_letter',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rankings', 'fail');
    }
}