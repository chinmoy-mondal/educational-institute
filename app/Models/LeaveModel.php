<?php

namespace App\Models;

use CodeIgniter\Model;

class LeaveModel extends Model
{
    protected $table = 'leaves';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',        // ✅ added
        'leave_type',
        'from_datetime',
        'to_datetime',
        'reason',
        'status' // Pending, Approved, Rejected, Cancelled
    ];

    protected $useTimestamps = true;

    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}