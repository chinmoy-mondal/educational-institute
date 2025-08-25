<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubjectToEvents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('results', [
            'class' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'null'       => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('events', 'subject');
    }
}
