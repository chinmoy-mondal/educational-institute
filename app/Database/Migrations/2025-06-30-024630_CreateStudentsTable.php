<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStudents extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'student_name'               => ['type' => 'VARCHAR', 'constraint' => 255],
            'roll'                       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'class'                      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'section'                    => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'esif'                       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'father_name'                => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'mother_name'                => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'dob'                        => ['type' => 'DATE', 'null' => true],
            'gender'                     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'phone'                      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'student_pic'                => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'birth_registration_number'  => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'father_nid_number'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'mother_nid_number'          => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'religion'                   => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],   // NEW
            'blood_group'                => ['type' => 'VARCHAR', 'constraint' => 10,  'null' => true],   // NEW
            'created_at'                 => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                 => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('students');
    }

    public function down()
    {
        $this->forge->dropTable('students');
    }
} 
