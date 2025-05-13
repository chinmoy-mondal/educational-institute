<?php

namespace App\Models;
use CodeIgniter\Model;

class AccountModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'name',
        'role',
        'designation',
        'subject',
        'gender',
        'phone',
        'email',
        'password',
    ];
}