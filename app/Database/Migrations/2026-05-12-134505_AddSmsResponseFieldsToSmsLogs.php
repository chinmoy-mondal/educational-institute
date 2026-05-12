<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSmsResponseFieldsToSmsLogs extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sms_logs', [

            'response' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'status',
            ],

            'error' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'response',
            ],

            'http_code' => [
                'type'       => 'INT',
                'constraint' => 5,
                'null'       => true,
                'after'      => 'error',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sms_logs', 'response');
        $this->forge->dropColumn('sms_logs', 'error');
        $this->forge->dropColumn('sms_logs', 'http_code');
    }
}
