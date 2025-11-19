<?php
namespace App\Models;

use CodeIgniter\Model;

class DrugsModel extends Model
{
    protected $table = 'drugs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'company',
        'drug_name',
        'drug_type',
        'group_name',
        'price',
        'quantity',
        'unit_type'
    ];
}