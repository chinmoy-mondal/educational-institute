<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTeacherAttendanceTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'teacher_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'remark' => [
                'type' => 'ENUM',
                'constraint' => ['Present', 'Absent', 'Late', 'Leave'],
                'default' => 'Present'
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('teacher_id', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('teacher_attendance');
    }

    public function down()
    {
        $this->forge->dropTable('teacher_attendance');
    }
}
