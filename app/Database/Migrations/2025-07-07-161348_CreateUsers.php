<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'name'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'           => ['type' => 'ENUM', 'constraint' => ['Teacher', 'Staff']],
            'designation'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'subject'        => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'gender'         => ['type' => 'ENUM', 'constraint' => ['Male', 'Female', 'Others']],
            'phone'          => ['type' => 'VARCHAR', 'constraint' => 20],
            'email'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'password'       => ['type' => 'VARCHAR', 'constraint' => 255],
            'picture'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'assagin_sub'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'account_status' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'permit_by'      => ['type' => 'BIGINT', 'constraint' => 20, 'unsigned' => true, 'null' => true],
            'religion'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'blood_group'    => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'position'       => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'bio'            => ['type' => 'TEXT', 'null' => true],
            'mpo_date'       => ['type' => 'DATE', 'null' => true],
            'index_number'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true], // NEW
            'social_profile' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'     => ['type' => 'DATETIME', 'null' => false],
            'updated_at'     => ['type' => 'DATETIME', 'null' => false],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
