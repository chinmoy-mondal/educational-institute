<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusToNotices extends Migration
{
    public function up()
    {
        // Add 'status' column after 'document_url'
        $fields = [
            'status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'after'      => 'document_url',
                'null'       => false,
                'comment'    => '1 = Active, 0 = Inactive'
            ]
        ];
        $this->forge->addColumn('notices', $fields);
    }

    public function down()
    {
        // Remove the column if rolling back
        $this->forge->dropColumn('notices', 'status');
    }
}