<?php
namespace App\Models;

use CodeIgniter\Model;

class FeesAmountModel extends Model
{
    protected $table = 'fees_amount';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'class',
        'section',
        'title_id',
        'unit',
        'fees',
        'created_at',
        'updated_at'
    ];
    protected $useTimestamps = true;
}