<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubjectToEvents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('events', [
            'subject' => [
                'type'       => 'INT',
                'null'       => true, // nullable in case some events don't have a subject
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('events', 'subject');
    }
}