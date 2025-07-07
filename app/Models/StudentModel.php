<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table      = 'students';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'student_name','roll','class','section','esif','father_name','mother_name',
        'dob','gender','phone','student_pic','birth_registration_number',
        'father_nid_number','mother_nid_number','religion','blood_group'
    ];

    protected $useTimestamps = true;
}
