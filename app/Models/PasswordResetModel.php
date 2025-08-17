<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    // Database table name
    protected $table = 'password_resets';

    // Primary key
    protected $primaryKey = 'id';

    // Fields allowed for insert/update
    protected $allowedFields = ['email', 'token', 'expires_at', 'used'];

    // Enable automatic created_at and updated_at
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Return data as array
    protected $returnType = 'array';
}