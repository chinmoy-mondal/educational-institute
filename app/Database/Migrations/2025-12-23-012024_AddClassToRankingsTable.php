<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddClassToRankingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('rankings', [
            'class' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'after'      => 'id', // optional
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rankings', 'class');
    }
}