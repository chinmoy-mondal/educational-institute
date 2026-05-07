<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
    protected $table      = 'patients';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'phone',
        'age',
        'gender',
        'address'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}