<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table      = 'students';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'student_name',
        'roll',
        'class',
        'section',
        'esif',
        'father_name',
        'mother_name',
        'dob',
        'gender',
        'phone',
        'student_pic',
        'birth_registration_number',
        'father_nid_number',
        'mother_nid_number',
        'religion',
        'blood_group',
        'assign_sub',
        'group',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
