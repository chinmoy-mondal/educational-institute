<?php

namespace App\Models;

use CodeIgniter\Model;

class RfidLogModel extends Model
{
    protected $table            = 'rfid_logs';
    protected $primaryKey       = 'id';

    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'card_id',
        'scan_time'
    ];

    protected $useTimestamps = false;
}
