<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSectionToRankingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('rankings', [
            'section' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'after'      => 'class'
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rankings', 'section');
    }
}