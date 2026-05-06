<?php

namespace App\Models;

use CodeIgniter\Model;

class PasswordResetModel extends Model
{
    protected $table      = 'password_resets';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'email',
        'token',
        'expires_at',
        'used'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $returnType = 'array';

    // 🔥 Auto-cast used field as boolean-like
    protected $casts = [
        'used' => 'boolean'
    ];

    // 🔐 Optional: safer default behavior
    protected $skipValidation = true;
}