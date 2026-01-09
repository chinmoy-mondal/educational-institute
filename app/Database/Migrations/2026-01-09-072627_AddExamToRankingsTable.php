<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddExamToRankingsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('rankings', [
            'exam' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'after'      => 'class', // ✅ place after class
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('rankings', 'exam');
    }
}