<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT',     'constraint' => 10,  'unsigned' => true, 'auto_increment' => true],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'          => ['type' => 'ENUM',    'constraint' => ['Teacher', 'Staff']],
            'designation'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'subject'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'gender'        => ['type' => 'ENUM',    'constraint' => ['Male', 'Female', 'Others']],
            'phone'         => ['type' => 'VARCHAR', 'constraint' => 20],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'password'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'picture'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'assagin_sub'   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'account_status'=> ['type' => 'TINYINT', 'constraint' => 1,   'default' => 0],
            //  NEW COLUMNS ↓
            'religion'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'blood_group'   => ['type' => 'VARCHAR', 'constraint' => 5,   'null' => true],
            // timestamps
            'created_at'    => ['type' => 'DATETIME', 'null' => false],
            'updated_at'    => ['type' => 'DATETIME', 'null' => false],
        ]);

        $this->forge->addKey('id', true);      // primary key
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
