<?php

namespace App\Models;

use CodeIgniter\Model;

class ResultModel extends Model
{
    protected $table      = 'results';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'student_id',
        'subject_id',
        'exam',
        'year',
        'written',
        'mcq',
        'practical',
        'total',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false; // because we handle created_at/updated_at manually
}
