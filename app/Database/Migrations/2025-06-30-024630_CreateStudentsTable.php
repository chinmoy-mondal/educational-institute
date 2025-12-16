<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'student_name'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'roll'                      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'class'                     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'section'                   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'esif'                      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'father_name'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'mother_name'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'dob'                       => ['type' => 'DATE', 'null' => true],
            'gender'                    => ['type' => 'ENUM', 'constraint' => ['Male', 'Female', 'Other'], 'default' => 'Male'],
            'phone'                     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'student_pic'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'birth_registration_number' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'father_nid_number'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'mother_nid_number'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'religion'                  => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'blood_group'               => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => true],
            'assign_sub'                => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'permission'                => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'null' => false],
            'created_at'                => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('students', true);
    }

    public function down()
    {
        $this->forge->dropTable('students', true);
    }
}
