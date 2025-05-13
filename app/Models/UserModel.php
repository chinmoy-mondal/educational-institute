<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'name', 'role', 'designation', 'subject', 'gender',
        'phone', 'email', 'password'
    ];
    protected $useTimestamps    = true;
}