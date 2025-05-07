<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; // name of your table
    protected $primaryKey = 'id'; // primary key

    protected $allowedFields = [
        'name',
        'role',
        'designation',
        'subject',
        'gender',
        'phone',
        'email',
        'password',
        'is_active'
    ];

    protected $useTimestamps = true; // if you have created_at and updated_at columns

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (!empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }
}