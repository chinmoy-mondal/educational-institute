<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategorySubcategoryToEvents extends Migration
{
    public function up()
    {
        $forge = \Config\Database::forge();
        $db    = \Config\Database::connect();

        // Get existing columns
        $existing = $db->getFieldNames('events');

        // Add 'category' if it doesn't exist
        if (!in_array('category', $existing)) {
            $forge->addColumn('events', [
                'category' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ]
            ]);
        }

        // Add 'subcategory' if it doesn't exist
        if (!in_array('subcategory', $existing)) {
            $forge->addColumn('events', [
                'subcategory' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 100,
                    'null'       => true,
                ]
            ]);
        }
    }

    public function down()
    {
        $forge = \Config\Database::forge();
        $db    = \Config\Database::connect();

        // Drop columns if they exist
        $existing = $db->getFieldNames('events');

        if (in_array('category', $existing) || in_array('subcategory', $existing)) {
            $forge->dropColumn('events', ['category','subcategory']);
        }
    }
}