<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users'; // your table name
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name', 'role', 'designation', 'subject',
        'gender', 'phone', 'email', 'password'
    ];

    protected $returnType = 'array';
    protected $useTimestamps = true; // if you have created_at/updated_at
}

