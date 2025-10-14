<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDocumentUrlToNotices extends Migration
{
    public function up()
    {
        // Add 'document_url' column after 'notice_date'
        $fields = [
            'document_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'notice_date'
            ],
        ];

        $this->forge->addColumn('notices', $fields);
    }

    public function down()
    {
        // Remove 'document_url' column
        $this->forge->dropColumn('notices', 'document_url');
    }
}