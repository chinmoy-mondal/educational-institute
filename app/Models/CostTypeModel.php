<?php

namespace App\Models;

use CodeIgniter\Model;

class CostTypeModel extends Model
{
    protected $table = 'cost_types';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'type_name'  // Only the field you want to insert/update
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}