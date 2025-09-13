<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateAttendanceTable extends Migration
{
    public function up()
    {
        // Drop columns attendance_date and attendance_time
        $fields = [
            'attendance_date',
            'attendance_time'
        ];

        foreach ($fields as $field) {
            if ($this->db->fieldExists($field, 'attendance')) {
                $this->forge->dropColumn('attendance', $field);
            }
        }
    }

    public function down()
    {
        // Recreate the dropped columns in case of rollback
        $this->forge->addColumn('attendance', [
            'attendance_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'attendance_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
        ]);
    }
}