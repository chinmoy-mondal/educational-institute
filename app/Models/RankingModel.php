<?php

namespace App\Models;

use CodeIgniter\Model;

class RankingModel extends Model
{
    protected $table = 'rankings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'student_id',
        'class',
        'exam',
        'new_roll',
        'student_name',
        'past_roll',
        'total',
        'percentage',
        'gpa',
        'gpa_without_forth',
        'grade_letter',
        'fail',
        'year',
        'created_at',
        'updated_at'
    ];
}