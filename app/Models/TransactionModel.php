<?php
namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'transaction_id',
        'sender_id',
        'sender_name',
        'receiver_id',
        'receiver_name',
        'amount',
        'purpose',
        'description',
        'created_at',
        'updated_at'
    ];
}