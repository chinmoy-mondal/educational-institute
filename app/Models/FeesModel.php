<?php
namespace App\Models;

use CodeIgniter\Model;

class FeesModel extends Model
{
    protected $table = 'fees';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title',
        'total_fees',
        'created_at',
        'updated_at'
    ];
}