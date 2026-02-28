<?php

namespace App\Models;

use CodeIgniter\Model;

class CostTypeModel extends Model
{
    protected $table = 'cost_types';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type_name',
        'created_at'
    ];
    protected $useTimestamps = true;
}