<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentBackupModel extends Model
{
    protected $table      = 'student_backup';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'student_id',
        'roll',
        'class',
        'section',
        'assign_sub',
        'year',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
}