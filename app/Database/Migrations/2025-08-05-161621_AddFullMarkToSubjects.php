<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFullMarkToSubjects extends Migration
{
    public function up()
    {
        $this->forge->addColumn('subjects', [
            'full_mark' => [
                'type'       => 'INT',
                'default'    => 100,
                'after'      => 'section', // 👈 Position the column after `section`
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('subjects', 'full_mark');
    }
}