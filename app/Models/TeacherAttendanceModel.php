<?php

namespace App\Models;

use CodeIgniter\Model;

class TeacherAttendanceModel extends Model
{
    protected $table = 'teacher_attendance';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'teacher_id',
        'remark',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
