<?php

namespace App\Models;

use CodeIgniter\Model;

class MarkingOpenModel extends Model
{
    protected $table = 'marking_open';
    protected $primaryKey = 'id';
    protected $allowedFields = ['exam_name', 'status', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}