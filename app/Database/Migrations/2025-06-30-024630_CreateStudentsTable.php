<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                           => [
                'type'           => 'INT',
                'auto_increment' => true,
                'null'           => false,
            ],
            'student_name'                => ['type' => 'VARCHAR', 'constraint' => 100],
            'roll'                        => ['type' => 'VARCHAR', 'constraint' => 20],
            'class'                       => ['type' => 'VARCHAR', 'constraint' => 20],
            'section'                     => ['type' => 'VARCHAR', 'constraint' => 20],
            'esif'                        => ['type' => 'VARCHAR', 'constraint' => 50],
            'father_name'                 => ['type' => 'VARCHAR', 'constraint' => 100],
            'mother_name'                 => ['type' => 'VARCHAR', 'constraint' => 100],
            'dob'                         => ['type' => 'DATE'],
            'gender'                      => ['type' => 'VARCHAR', 'constraint' => 10],
            'phone'                       => ['type' => 'VARCHAR', 'constraint' => 20],
            'student_pic'                 => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'birth_registration_number'   => ['type' => 'VARCHAR', 'constraint' => 30],
            'father_nid_number'           => ['type' => 'VARCHAR', 'constraint' => 30],
            'mother_nid_number'           => ['type' => 'VARCHAR', 'constraint' => 30],
            'created_at'                  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                  => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
}
