<?php

namespace App\Models;

use CodeIgniter\Model;

class UserCollectionsPayModel extends Model
{
    protected $table = 'user_collections_pay'; // table name
    protected $primaryKey = 'id';               // primary key

    protected $allowedFields = [
        'user_id',
        'user_name',
        'amount_paid',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;       // automatically fill created_at & updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $returnType = 'array';       // return as array
}