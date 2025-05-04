<?php namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table = 'students';
    protected $allowedFields = [
    'student_name', 'roll', 'class', 'section', 'esif',
    'dob', 'phone',
    'student_pic', // ✅ this must be here
    'birth_registration_pic',
    'father_id_pic',
    'mother_id_pic',
];

}
