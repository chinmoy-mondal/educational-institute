<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimeToEvents extends Migration
{
    public function up()
    {
        $fields = [
            'start_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'end_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
        ];

        $this->forge->addColumn('events', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('events', ['start_time', 'end_time']);
    }
}