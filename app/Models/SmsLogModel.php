<?php

namespace App\Models;

use CodeIgniter\Model;

class SmsLogModel extends Model
{
    protected $table      = 'sms_logs';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'student_name',
        'phone_number',
        'message',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false; // we manually set created_at
}