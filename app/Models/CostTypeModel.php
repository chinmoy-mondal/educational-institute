<?php

namespace App\Models;

use CodeIgniter\Model;

class CostTypeModel extends Model
{
    protected $table      = 'cost_types';      // Table name
    protected $primaryKey = 'id';              // Primary key

    protected $allowedFields = ['type_name'];  // Fields that can be inserted/updated

    // Enable timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = null;           // Not using updated_at
}
