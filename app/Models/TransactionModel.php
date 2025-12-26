<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table      = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'transaction_id',
        'sender_id',
        'sender_name',
        'receiver_id',
        'receiver_name',
        'amount',
        'discount',
        'month',
        'purpose',
        'description',
        'status',
        'activity' // new field
    ];

    // ✅ Automatic timestamps
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}