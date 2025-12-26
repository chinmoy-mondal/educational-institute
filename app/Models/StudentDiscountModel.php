<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentDiscountModel extends Model
{
    protected $table = 'student_discount';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'student_id',
        'amount',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
}